<?php
class FaqController extends Controller
{
	public function actionIndex()
	{
		$criteria = new CDbCriteria();
		
		$criteria->condition = 'category = ?';
		$criteria->params = array(Faq::GENERAL);
		$criteria->order = 't.order ASC';
		
		$generals = Faq::model()->findAll($criteria);
		
		$criteria->params = array(Faq::STUDENT);
		
		$students = Faq::model()->findAll($criteria);
		
		$criteria->params = array(Faq::TUTOR);
		
		$tutors = Faq::model()->findAll($criteria);
		
		$this->render('index', array(
				'generals'=>$generals,
				'students'=>$students,
				'tutors'=>$tutors,
				'message'=>app()->user->getFlash('message'),
		));
	}
	
	/**
	 * edit or create new subject
	 */
	public function actionEdit()
	{
		$id = CPropertyValue::ensureInteger(request()->getParam('id', 0));
	
		if($id == 0)
		{
			$model = new Faq();
		}
		else
		{
			$model = Faq::model()->findByPk($id);
		}
	
		$model->old_category = $model->category;
		
		// collect user input data
		$faq = app()->request->getPost('Faq', false);
	
		if($faq)
		{
			$model->attributes = $faq;
			
			$model->save();

			app()->user->setFlash('message', $id == 0 ? 'Add new faq successfully' : 'Edit faq successfully');
			$this->redirect(url('/faq'));
		}
	
		$this->render('edit', array(
				'model'=>$model,
		));
	}
	
	/**
	 * delete, draft, publish multiple record
	 */
	public function actionManageMultiRecord()
	{
		$ids = CPropertyValue::ensureString(request()->getParam('ids'));
		$action = CPropertyValue::ensureString(request()->getParam('action'));
		
		$ids = explode(',', $ids);
		
		foreach ($ids as $id)
		{
			$faq = Faq::model()->findByPk($id);
	
			if($action == 'delete')
			{
				$faq->delete();
			}
			elseif($action == 'draft')
			{
				$faq->status = Faq::DRAFT;
				$faq->save(false);
			}
			else
			{
				$faq->status = Faq::PUBLISHED;
				$faq->save(false);
			}
		}
	
		echo json_encode(array('success'=>true));
	}
	
	/**
	 * change faq order
	 */
	public function actionChangeOrder()
	{
		$id = CPropertyValue::ensureInteger(request()->getParam('id'));
		$type = CPropertyValue::ensureString(request()->getParam('type'));
		
		$faq = Faq::model()->findByPk($id);
		
		if(!empty($faq))
		{
			$criteria = new CDbCriteria();
			
			//find the closest faq
			if($type == 'up')
			{
				$criteria->condition = 'category = ? AND t.order < ?';
				$criteria->params = array($faq->category, $faq->order);
				$criteria->order = 't.order DESC';
			}
			else
			{
				$criteria->condition = 'category = ? AND t.order > ?';
				$criteria->params = array($faq->category, $faq->order);
				$criteria->order = 't.order ASC';
			}
		
			$change = Faq::model()->find($criteria);
			
			//switch order
			if(!empty($change))
			{
				$tmp = $faq->order;
				$faq->order = $change->order;
				$change->order = $tmp;
				
				$faq->save();
				$change->save();
				
				echo json_encode(array('success'=>true, 'id'=>$faq->id, 'change_id'=>$change->id));
			}
			else
			{
				echo json_encode(array('success'=>false,));
			}
		}
	}
}