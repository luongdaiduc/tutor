<?php
class Setting extends BaseSetting
{
	public $active_db = 'db';
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getDbConnection()
	{
		if($this->active_db != 'db')
		{
			$db = Yii::app()->{$this->active_db};
			if ($db instanceof CDbConnection) {
				$db->setActive(true);
				return $db;
			}
		}
		else
		{
			$db = Yii::app()->db;
			if ($db instanceof CDbConnection) {
				$db->setActive(true);
				return $db;
			}
		}
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
				$this->created = date('Y-m-d H:i:s');
			}
			else
				$this->updated = date('Y-m-d H:i:s');
			return true;
		}
	}
	
	/**
	 * return cache
	 */
	public static function getSettingCache()
	{
		$settings = unserialize(Yii::app()->cache->get(Yii::app()->params['cacheSettingsId']));
		
		if(!$settings)
		{
			$models = Setting::model()->findAll();
	
			foreach ($models as $model)
			{
				$settings[$model->name] = $model->value;
			}
	
			Yii::app()->cache->set(Yii::app()->params['cacheSettingsId'], serialize($settings), Yii::app()->params['cache_expire']);
		}
	
		return $settings;
	}
	
}