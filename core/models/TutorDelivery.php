<?php
class TutorDelivery extends BaseTutorDelivery
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * return all tutor delivery ids
	 */
	public function getTutorDeliveryIds()
	{
		$ref_account_id = app()->user->id ? app()->user->id : 0;
		$models = TutorDelivery::model()->findAll('ref_account_id = ?', array($ref_account_id));
	
		$tutor_delivery_ids = array();
		if(!empty($models))
		{
			foreach ($models as $model)
			{
				$tutor_delivery_ids[] = $model->ref_delivery_id;
			}
		}
	
		return $tutor_delivery_ids;
	}
	
}