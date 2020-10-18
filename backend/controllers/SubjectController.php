<?php
class SubjectController extends Controller
{
	public function actionIndex()
	{
		$dataProvider = Subject::model()->search();

		$this->render('index', array(
				'dataProvider'=>$dataProvider,
				'message'=>app()->user->getFlash('message'),
		));
	}

	/**
	 * edit or create new subject
	 */
	public function actionEdit()
	{
		$id = CPropertyValue::ensureInteger(request()->getParam('id', 0));
		$model = Subject::model()->findByPk($id);

		if(!$model)
		{
			$model = new Subject();
		}

		// collect user input data
		$subject = app()->request->getPost('Subject', false);

		if($subject)
		{
			//defined whether subject parent changed or not
			if($model->ref_parent_id != $subject['ref_parent_id'])
			{
				$model->is_change_parent = true;
				$model->old_parent_id = $model->ref_parent_id;
				$model->old_level = $model->level;
				$model->old_root = $model->root;
			}

			$model->attributes = $subject;

			if($model->isNewRecord)
			{
				$model->save();
				
				if(empty($subject['ref_parent_id']))
				{
					$model->level = 1;
					$model->root = $model->id;
					$model->ref_parent_id = $model->id;
					
				}
				else
				{
					$parent = Subject::model()->findByPk($subject['ref_parent_id']);
					
					$model->level = $parent->level + 1;
					$model->root = $parent->root . '-' . (Subject::model()->count('ref_parent_id = ? and level > 1', array($parent->id)) + 1); 
					
				}
				
			}
			else 
			{
				$this->saveRootLevel($model);
				
			}
			
			$model->save();
			
			//redefine all subject root
			$subjects = Subject::model()->findAll();
			
			if(!empty($subjects))
			{
				foreach ($subjects as $sub)
				{
					$this->saveIndex($sub->id);
				}
			}
			
			app()->user->setFlash('message', $id == 0 ? 'Add new subject successfully' : 'Edit subject successfully');
			$this->redirect(url('/subject'));
		}

		//data for drop down list
		$exclude_array = array();

		if($id > 0)
		{
			$criteria = new CDbCriteria();
			$criteria->condition = 'root like "' . $model->root . '%"';

			$child_subjects = Subject::model()->findAll($criteria);

			if(!empty($child_subjects))
			{
				foreach ($child_subjects as $child_subject)
				{
					$exclude_array[] = $child_subject->id;
				}
			}
		}

		$parent_subjects = Subject::listNestedSubject($exclude_array);

		$this->render('edit', array(
				'model'=>$model,
				'parent_subjects'=>$parent_subjects
		));
	}

	/**
	 * delete, disable, enable multiple record
	 */
	public function actionManageMultiRecord()
	{
		$ids = CPropertyValue::ensureString(request()->getParam('ids'));
		$action = CPropertyValue::ensureString(request()->getParam('action'));

		$ids = explode(',', $ids);

		$undelete_subject = array();
		foreach ($ids as $id)
		{
			$exist = false;
			$subject = Subject::model()->findByPk($id);
				
			//check whether the selected subject is belong to tutor or not
			$exist = TutorSubject::model()->exists('ref_subject_id = ?', array($id));
			
			if($exist)
			{
				if(!in_array($subject->name, $undelete_subject))
				{
					$undelete_subject[] = $subject->name;
				}
			}
			
			//action for subject's child
			$criteria = new CDbCriteria();
			$criteria->condition = 'root like "' . $subject->root . '-%"';
			
			$child_subjects = Subject::model()->findAll($criteria);
			
			if(!empty($child_subjects))
			{
				foreach ($child_subjects as $child_subject)
				{
					//check whether the subject is belong to tutor or not
					$exist = TutorSubject::model()->exists('ref_subject_id = ?', array($child_subject->id));
					
					if($exist)
					{
						if(!in_array($child_subject->name, $undelete_subject))
						{
							$undelete_subject[] = $child_subject->name;
						}
					}
				}
			}
				
			if(!$exist)
			{
				if($action == 'delete')
				{
					//delete child subject
					if(!empty($child_subjects))
					{
						foreach ($child_subjects as $child_subject)
						{
							$child_subject->delete();
						}
					}
					
					Subject::model()->deleteByPk($id);
				}
				else
				{
					//disable or enable child subject
					if(!empty($child_subjects))
					{
						foreach ($child_subjects as $child_subject)
						{
							$child_subject->status = ($action == 'disable') ? Subject::DISABLE :  Subject::ACTIVE;
							$child_subject->save();
						}
					}
					
					//disable or enable subject
					$subject->status = ($action == 'disable') ? Subject::DISABLE :  Subject::ACTIVE;
					$subject->save();
				}
			}

		}
		
		if(empty($undelete_subject))
		{
			echo json_encode(array('success'=>true));
		}
		else 
		{
			echo json_encode(array('success'=>false, 'message'=>'Subject ' . implode(', ', $undelete_subject) . ' have been used by another tutor. Update failed.'));
		}
	}

	public function saveRootLevel($model)
	{
		$a = array();
		$b = array();
		
		//save root and level
		if(empty($model->ref_parent_id))
		{
			$model->old_level = $model->level;
			
			$model->root = $model->id;
			$model->level = 1;
			$model->ref_parent_id = $model->id;
		
			if(!$model->isNewRecord)
			{
				if($model->old_level > 1)
				{
					//redefined other subject's root
					$other_subjects = Subject::model()->findAll('ref_parent_id = ? and id <> ?', array($model->old_parent_id, $model->id));
						
					if(!empty($other_subjects))
					{
						foreach ($other_subjects as $other_subject)
						{
							$root = $model->root;
							$other_root =  $other_subject->root;
								
							$array_root = explode('-', $root);
							$array_other_root = explode('-', $other_root);
								
							if($array_other_root[($other_subject->level - 1)] > 1 && ($array_other_root[($other_subject->level - 1)] > $array_root[($model->level - 1)]))
							{
								$array_other_root[($other_subject->level - 1)] = $array_other_root[($other_subject->level - 1)] - 1;
							}
								
							$array_other_root = implode('-', $array_other_root);
								
							$other_subject->root = $array_other_root;
							$other_subject->save();
								
							//redefined child subject's root
							$criteria = new CDbCriteria();
							$criteria->condition = 'root like "' . $other_root . '-%"';
								
							$other_child_subjects = Subject::model()->findAll($criteria);
								
							if(!empty($other_child_subjects))
							{
								foreach ($other_child_subjects as $other_child_subject)
								{
									$new_parent_root = $other_subject->root;
										
									$old_root = $other_child_subject->root;
									$old_root = explode('-', $old_root);
										
									$branch = array();
									for($i = $other_subject->level; $i < count($old_root); $i++)
									{
									$branch[] = $old_root[$i];
									}
										
									$other_child_subject->root = $new_parent_root . '-' . implode('-', $branch);
										
									$a[] = $other_child_subject;
								}
							}
						}
					
					}
							
				}
				
				//redefined child subject's root
				$criteria = new CDbCriteria();
				$criteria->condition = 'root like "' . $model->old_root . '-%"';

				$child_subjects = Subject::model()->findAll($criteria);

				if(!empty($child_subjects))
				{
					foreach ($child_subjects as $child_subject)
					{
						$new_parent_root = $model->root;

						$old_root = $child_subject->root;
						$old_root = explode('-', $old_root);

						$branch = array();
						for($i = $model->old_level; $i < count($old_root); $i++)
						{
							$branch[] = $old_root[$i];
						}

						$child_subject->root = $new_parent_root . '-' . implode('-', $branch);
						$child_subject->level = $model->level + ($child_subject->level - $model->old_level);

						$b[] = $child_subject;
					}
				}
			}
		}
		else
		{
			//save data if parent subject changed
			if($model->is_change_parent)
			{

				if(!$model->isNewRecord)
				{
					if($model->old_level > 1)
					{
						//redefined other subject's root
						$other_subjects = Subject::model()->findAll('ref_parent_id = ? and id <> ?', array($model->old_parent_id, $model->id));
						
						if(!empty($other_subjects))
						{
							foreach ($other_subjects as $other_subject)
							{
								$root = $model->root;
								$other_root =  $other_subject->root;
						
								$array_root = explode('-', $root);
								$array_other_root = explode('-', $other_root);
						
								if($array_other_root[($other_subject->level - 1)] > 1 && ($array_other_root[($other_subject->level - 1)] > $array_root[($model->level - 1)]))
								{
									$array_other_root[($other_subject->level - 1)] = $array_other_root[($other_subject->level - 1)] - 1;
								}
						
								$array_other_root = implode('-', $array_other_root);
						
								$other_subject->root = $array_other_root;
								$other_subject->save();
						
								//redefined child subject's root
								$criteria = new CDbCriteria();
								$criteria->condition = 'root like "' . $other_root . '-%"';
						
								$other_child_subjects = Subject::model()->findAll($criteria);
						
								if(!empty($other_child_subjects))
								{
									foreach ($other_child_subjects as $other_child_subject)
									{
										$new_parent_root = $other_subject->root;
						
										$old_root = $other_child_subject->root;
										$old_root = explode('-', $old_root);
						
										$branch = array();
										for($i = $other_subject->level; $i < count($old_root); $i++)
										{
										$branch[] = $old_root[$i];
										}
						
										$other_child_subject->root = $new_parent_root . '-' . implode('-', $branch);
						
										$a[] = $other_child_subject;
									}
								}
							}
						
						}
						
					}
					
					//find subject's parent
					$parent = Subject::model()->findByPk($model->ref_parent_id);

					$count = Subject::model()->count('ref_parent_id = ? and level > 1', array($model->ref_parent_id));

					$model->level = $parent->level + 1;
					$model->root = $parent->root . '-' . ($count + 1);

					//redefined child subject's root
					$criteria = new CDbCriteria();
					$criteria->condition = 'root like "' . $model->old_root . '-%"';

					$child_subjects = Subject::model()->findAll($criteria);

					if(!empty($child_subjects))
					{
						foreach ($child_subjects as $child_subject)
						{
							$new_parent_root = $model->root;

							$old_root = $child_subject->root;
							$old_root = explode('-', $old_root);

							$branch = array();
							for($i = $model->old_level; $i < count($old_root); $i++)
							{
								$branch[] = $old_root[$i];
							}

							$child_subject->root = $new_parent_root . '-' . implode('-', $branch);
							$child_subject->level = $model->level + ($child_subject->level - $model->old_level);

							$b[] = $child_subject;
						}
					}
				}
					
			}
		}

		if(!empty($a))
		{
			foreach ($a as $aa)
			{
				$aa->save();
			}
		}
		if(!empty($b))
		{
			foreach ($b as $bb)
			{
				$bb->save();
			}
		}
	}
	
	/**
	 * define index to sort subject
	 * @param int $id
	 */
	public function saveIndex($id)
	{
		$subject = Subject::model()->findByPk($id);
		
		if($subject->level == 1)
		{
			//define subject'index
			$sames = Subject::model()->findAll('t.level = 1 ORDER BY t.name');
			
			if(!empty($sames))
			{
				foreach ($sames as $idx => $same)
				{	
					$tmp = $idx + 1;
					
					$index = '';
					
					while ($tmp > 9) {
						$tmp = $tmp - 9;
						
						if($tmp > 9)
						{
							$index .= $index . '9';
						}
						else
						{
							$index .= !empty($index) ? $index . $tmp : '9' . $tmp;
						}
					}
						
					$same->index = !empty($index) ? $index : $tmp;
					$same->root = $same->index;
					$same->save();
			
				}
			}
		}
		else
		{
			//define subject'index
			$sames = Subject::model()->findAll('t.ref_parent_id = ? AND t.level > 1 ORDER BY t.name', array($subject->ref_parent_id));
				
			if(!empty($sames))
			{
				
				foreach ($sames as $idx => $same)
				{
					$parent = Subject::model()->find('id = :P', array(':P'=>$same->ref_parent_id));
					
					$tmp = $idx + 1;
					
					$index = '';
					
					while ($tmp > 9) {
						$tmp = $tmp - 9;
						
						if($tmp > 9)
						{
							$index .= $index . '9';
						}
						else
						{
							$index .= !empty($index) ? $index . $tmp : '9' . $tmp;
						}
					}
					
					$index = !empty($index) ? $index : $tmp;
					
					$same->index = $parent->root . '-' . $index;
					
					$same->root = $same->index;
					$same->save();
				
				}
			}
			
		}
			
	}
	
}