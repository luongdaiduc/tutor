<?php
class SubjectLevel extends BaseSubjectLevel
{
	const ACTIVE = 1;
	const INACTIVE = 0;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	* (non-PHPdoc)
	* @see BaseLeads::rules()
	*/
	public function relations()
	{
		$relations = array(
				);
	
		return CMap::mergeArray(parent::relations(), $relations);
	}
	
	public function rules()
	{
		$rules = array(
				);
	
		return CMap::mergeArray(parent::rules(), $rules);
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
			else
				$this->updated = date('Y-m-d');
			
			//clear cache
			app()->cache->delete(app()->params['cacheLevelId']);
				
			return true;
		}
	}
	
	/**
	 * return cache
	 */
	public static function getLevelCache()
	{
		$levels = unserialize(app()->cache->get(app()->params['cacheLevelId']));
	
		if(!$levels)
		{	
			$models = SubjectLevel::model()->findAll('status = ?', array(SubjectLevel::ACTIVE));
				
			if(!empty($models))
			{
				foreach ($models as $model)
				{
					$levels[$model->id] = $model->name;
				}
			}
			app()->cache->set(app()->params['cacheLevelId'], serialize($levels), app()->params['cache_expire']);
		}
	
		return $levels;
	}
}