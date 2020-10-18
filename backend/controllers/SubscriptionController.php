<?php
class SubscriptionController extends Controller
{
	public function actionIndex()
	{
		$dataProvider = Subscription::model()->search();
		
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
		$model = Subscription::model()->findByPk($id);
	
		if(!$model)
		{
			$model = new Subscription();
		}
	
		// collect user input data
		$subscription = app()->request->getPost('Subscription', false);
		if($subscription)
		{
			$model->attributes = $subscription;
			$model->currency = $this->settings['default_currency_symbol'];
				
			if($model->save())
			{
				app()->user->setFlash('message', ($id == 0) ? 'Add new subscription successfully' : 'Edit subscription successfully');
				$this->redirect(url('/subscription'));
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
			$subscription = Subscription::model()->findByPk($id);
	
			if($action == 'delete')
			{
				$subscription->delete();
			}
			else
			{
				$subscription->status = ($action == 'draft') ? Subscription::DRAFT : Subscription::PUBLISHED;
				$subscription->save();
			}
		}
	
		echo json_encode(array('success'=>true));
	}
}