<?php
class TutorStatistic extends BaseTutorStatistic
{
	const PROFILE_VIEW = 1;
	const PROFILE_SEARCH = 2;
	
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
			
			return true;
		}
	}
}