<?php
class Page extends BasePage
{
	const DRAFT = 0;
	const PUBLISHED = 1;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function rules()
	{
		$rules = array(
				array('slug', 'unique'),
		);
	
		return CMap::mergeArray(parent::rules(), $rules);
	}
	
	public function relations()
	{
		$relations = array(
				'blocks' => array(self::MANY_MANY, 'Block', 'page_blocks(ref_page_id, ref_block_id)'),
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
				$this->updated = date('Y-m-d H:i:s');
			}
			else
				$this->updated = date('Y-m-d H:i:s');
			return true;
		}
	}
	
	/**
	 * search all pages except pages was pre-created by sql
	 */
	public function searchCreated()
	{
		$criteria = new CDbCriteria();
	
		$criteria->condition = 'id > 0';
	
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}