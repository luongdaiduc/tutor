<?php
class DeliveryController extends Controller
{
	public function actionIndex()
	{
		$dataProvider = Delivery::model()->search();
	
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
			$model = new Delivery();
		}
		else
		{
			$model = Delivery::model()->findByPk($id);
		}
	
		// collect user input data
		$delivery = app()->request->getPost('Delivery', false);
	
		if($delivery)
		{
			$model->attributes = $delivery;
			
			$model->save();

			app()->user->setFlash('message', $id == 0 ? 'Add new delivery successfully' : 'Edit delivery successfully');
			$this->redirect(url('/delivery'));
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
			$delivery = Delivery::model()->findByPk($id);
	
			if($action == 'delete')
			{
				$delivery->delete();
			}
			elseif($action == 'draft')
			{
				$delivery->status = Delivery::INACTIVE;
				$delivery->save(false);
			}
			else
			{
				$delivery->status = Delivery::ACTIVE;
				$delivery->save(false);
			}
		}
	
		echo json_encode(array('success'=>true));
	}
}