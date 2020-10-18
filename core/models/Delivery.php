<?php
class Delivery extends BaseDelivery
{
	const ACTIVE = 1;
	const INACTIVE = 0;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function rules()
	{
		$rules = array(
			array('name', 'required'),
		);
	
		return CMap::mergeArray(parent::rules(), $rules);
	}
	
	public function relations()
	{
		$relations = array(
				
		);
	
		return CMap::mergeArray(parent::relations(), $relations);
	}
	
	/**
	 * save created date or updated date
	 * (non-PHPdoc)
	 * @see CActiveRecord::beforeSave()
	 */
	protected function beforeSave()
	{
		if (parent::beforeSave()) {
			if ($this->isNewRecord) {
				$this->created = date('Y-m-d');
			}
			
			//clear cache
			app()->cache->delete(app()->params['cacheDeliveryId']);
	
			return true;
		}
	}
	
	/**
	 * get all deliveries
	 */
	public function allDeliveries()
	{
		$deliveries = Delivery::model()->findAll('status = ?', array(self::ACTIVE));
		
		return $deliveries;
	}
	
	/**
	 * return cache
	 */
	public static function getDeliveryCache()
	{
		$delivery = unserialize(app()->cache->get(app()->params['cacheDeliveryId']));
	
		if(!$delivery)
		{
			$models = Delivery::model()->findAll('status = ?', array(Delivery::ACTIVE));
	
			if(!empty($models))
			{
				foreach ($models as $model)
				{
					$delivery[$model->id] = $model->name;
				}
			}
			app()->cache->set(app()->params['cacheDeliveryId'], serialize($delivery), app()->params['cache_expire']);
		}
	
		return $delivery;
	}
}