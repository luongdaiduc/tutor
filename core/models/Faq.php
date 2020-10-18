<?php
/**
 * 
 * @author Administrator
 */
class Faq extends BaseFaq
{
	const DRAFT = 0;
	const PUBLISHED = 1;
	
	const GENERAL = 0;
	const STUDENT = 1;
	const TUTOR = 2;
	
	public $old_category;
	
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
				$this->created = date('Y-m-d');
			}
			else
				$this->updated = date('Y-m-d');
			
			if($this->isNewRecord || ($this->old_category != $this->category && !is_null($this->old_category)))
			{
				//save faq order
				$criteria = new CDbCriteria();
				
				$criteria->condition = 'category = ?';
				$criteria->params = array($this->category);
				$criteria->order = 't.order DESC';
					
				$prev = Faq::model()->find($criteria);
				
				if(!empty($prev))
				{
					$this->order = $prev->order + 1;
				}
				else
				{
					$this->order = 1;
				}
			}
			
			return true;
		}
	}
	
}