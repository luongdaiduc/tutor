<?php
class State extends BaseState
{
	const NOT_DEFAULT = 0;
	const IS_DEFAULT = 1;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
				$this->created = date('Y-m-d H:i:s');
			}
			else
				$this->updated = date('Y-m-d H:i:s');
			
			//set default
			if($this->is_default == self::IS_DEFAULT)
			{
				$state = State::model()->find('is_default = ?', array(self::IS_DEFAULT));
				
				if(!empty($state))
				{
					//reset default state
					$state->is_default = self::NOT_DEFAULT;
					$state->save();
				}
				
				$this->is_default = self::IS_DEFAULT;
			}
			
			//clear cache
			app()->cache->delete(app()->params['cacheStatesId']);
			
			return true;
		}
	}
	
	/**
	 * return cache
	 */
	public static function getstateCache()
	{
		$states = unserialize(app()->cache->get(app()->params['cacheStatesId']));
	
		if(!$states)
		{
			$criteria = new CDbCriteria();
			
			$criteria->order = 'is_default DESC, state ASC';
			
			$models = State::model()->findAll($criteria);
			
			if(!empty($models))
			{
				foreach ($models as $model)
				{
					$states[$model->id] = $model->state;
				}
			}
			app()->cache->set(app()->params['cacheStatesId'], serialize($states), app()->params['cache_expire']);
		}
	
		return $states;
	}
	
}