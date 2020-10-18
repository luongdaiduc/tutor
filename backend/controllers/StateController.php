<?php
class StateController extends Controller
{
	public function actionIndex()
	{
		$dataProvider = State::model()->search();
		
		$this->render('index', array(
				'dataProvider'=>$dataProvider,
				'message'=>app()->user->getFlash('message'),
				));
	}
	
	/**
	 * edit or create new subject
	 */
	public function actionEdit($id = 0)
	{
		$id = CPropertyValue::ensureInteger($id);
		$model = State::model()->findByPk($id);
		
		if(!$model)
		{
			$model = new State();
		}

		// collect user input data
		$state = app()->request->getPost('State', false);		
		if($state)
		{
			$model->attributes = $state;
			
			if($model->save())
			{
				app()->user->setFlash('message', ($id == 0) ? 'Add new state successfully' : 'Edit state successfully');
				$this->redirect(url('/state'));
			}
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
			$state = State::model()->findByPk($id);
	
			if($action == 'delete')
			{
				$state->delete();
			}
		}
		
		echo json_encode(array('success'=>true));
	}

}
