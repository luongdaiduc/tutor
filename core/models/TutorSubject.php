<?php
class TutorSubject extends BaseTutorSubject
{
	const ACTIVE = 1;
	const DISABLE = 0;
	
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
				array('ref_account_id, ref_subject_id, experience, hourly_rate, status', 'numerical', 'integerOnly'=>true, 'message'=>'{attribute} ' . Common::translate('validation', 'must be an integer')),
				array('experience, hourly_rate', 'required', 'message'=>'{attribute} ' . Common::translate('validation', 'cannot be blank')),
		);
	
		return CMap::mergeArray(parent::rules(), $rules);
	}
	
	public function relations()
	{
		$relations = array(
				'subjects' => array(self::BELONGS_TO, 'Subject', 'ref_subject_id'),
				'accounts' => array(self::BELONGS_TO, 'Account', 'ref_account_id'),
				'subject_levels' => array(self::BELONGS_TO, 'SubjectLevel', 'level')
		);
	
		return CMap::mergeArray(parent::relations(), $relations);
	}
	
	public function attributeLabels()
	{
		$labels = array(
				'experience' => Common::translate('register', 'Experience'),
				'hourly_rate' => Common::translate('register', 'Hourly Rate'),
		);
	
		return CMap::mergeArray(parent::attributeLabels(), $labels);
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
	 * save cache for tutor's subjects
	 * (non-PHPdoc)
	 */
	protected function afterSave()
	{
		if (parent::afterSave()) {
			
			//clear cache
			app()->cache->delete(app()->params['cacheTutorSubjectId'. $this->ref_account_id]);
			
			$this->getTutorSubjectCache($this->ref_account_id);
			
			return true;
		}
	}
	
	/**
	 * return cache
	 * @param integer $ref_account_id
	 */
	public static function getTutorSubjectCache($ref_account_id)
	{
		$subjects = unserialize(Yii::app()->cache->get(Yii::app()->params['cacheTutorSubjectId'] . $ref_account_id));
	
		if(!$subjects)
		{
			$models = TutorSubject::model()->findAll('ref_account_id = ? AND t.status = ?', array($ref_account_id, TutorSubject::ACTIVE));
	
			foreach ($models as $model)
			{
				$subjects[] = $model->subjects->name;
			}
	
			Yii::app()->cache->set(Yii::app()->params['cacheTutorSubjectId'] . $ref_account_id, serialize($subjects), Yii::app()->params['cache_expire']);
		}
	
		return $subjects;
	}
	
	/**
	 * search all tutor subjects
	 * @param $integer $ref_account_id
	 */
	public function searchTutorSubject($ref_account_id)
	{
		$criteria = new CDbCriteria();
		$criteria->condition = 'ref_account_id = ?';
		$criteria->params = array($ref_account_id);
		
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
}