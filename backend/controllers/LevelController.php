<?php
class LevelController extends Controller
{
	public function actionIndex()
	{
		$dataProvider = SubjectLevel::model()->search();
	
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
	
		if($id == 0)
		{
			$model = new SubjectLevel();
		}
		else
		{
			$model = SubjectLevel::model()->findByPk($id);
		}
	
		// collect user input data
		$level = app()->request->getPost('SubjectLevel', false);
	
		if($level)
		{
			$model->attributes = $level;
			
			$model->save();

			app()->user->setFlash('message', $id == 0 ? 'Add new level successfully' : 'Edit level successfully');
			$this->redirect(url('/level'));
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
			$level = SubjectLevel::model()->findByPk($id);
	
			if($action == 'delete')
			{
				$level->delete();
			}
			elseif($action == 'draft')
			{
				$level->status = SubjectLevel::INACTIVE;
				$level->save(false);
			}
			else
			{
				$level->status = SubjectLevel::ACTIVE;
				$level->save(false);
			}
		}
	
		echo json_encode(array('success'=>true));
	}
}