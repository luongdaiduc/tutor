<?php
class Template extends BaseTemplate
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
	
	public function rules()
	{
		$rules = array(
			array('name', 'required'),
			array('name', 'unique'),
		);
	
		return CMap::mergeArray(parent::rules(), $rules);
	}
}