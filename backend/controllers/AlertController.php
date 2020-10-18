<?php
class AlertController extends Controller
{
	public function actionIndex()
	{
		$dataProvider = Error::model()->searchError();
		
		$this->render('index', array(
				'dataProvider'=>$dataProvider,
		));
	}
	
	/**
	 * delete alert
	 */
	public function actionManageMultiRecord()
	{
		$ids = CPropertyValue::ensureString(request()->getParam('ids'));
		$action = CPropertyValue::ensureString(request()->getParam('action'));
	
		$ids = explode(',', $ids);
	
		foreach ($ids as $id)
		{
			$error = Error::model()->findByPk($id);
	
			if($action == 'delete')
			{
				$error->delete();
			}
		}
	
		echo json_encode(array('success'=>true));
	}
	
	/**
	 * view alert detail
	 */
	public function actionDetail()
	{
		$id = CPropertyValue::ensureInteger(app()->request->getParam('id'));
	
		$model = Error::model()->findByPk($id);
	
		//first error id
		$first = $model->firstError();
		//last error id
		$last = $model->lastError();
		//previous error id
		$prev = $model->prevError();
		//next error id
		$next = $model->nextError();
	
		if(app()->request->isAjaxRequest)
		{
			//hide prev or next button
			$hide_prev = $id == $first;
			$hide_next = $id == $last;
				
			$html = $this->renderPartial('_detail', array('error'=>$model), true);
				
			echo json_encode(array('success'=>true, 'html'=>$html, 'prev_id'=>$prev, 'next_id'=>$next, 'hide_prev'=>$hide_prev, 'hide_next'=>$hide_next));
		}
		else
		{
			$this->render('detail', array(
					'error'=>$model,
					'first'=>$first,
					'last'=>$last,
					'prev'=>$prev,
					'next'=>$next,
			));
		}
	}
}