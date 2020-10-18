<?php
class TutorPremium extends BaseTutorPremium
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
	
	public function rules()
	{
		$rules = array(
				
		);
	
		return CMap::mergeArray(parent::rules(), $rules);
	}
	
	public function relations()
	{
		$relations = array(
			'subjects'=>array(self::BELONGS_TO, 'Subject', 'ref_subject_id'),
			'accounts'=>array(self::BELONGS_TO, 'Account', 'ref_account_id'),	
		);
	
		return CMap::mergeArray(parent::relations(), $relations);
	}
	
}