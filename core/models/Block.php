<?php
/**
 * 
 * @author Administrator
 * @property Page[] $pages
 */
class Block extends BaseBlock
{
	public $allPages = '';
	public $target = array();
	
	const DRAFT = 0;
	const PUBLISHED = 1;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function rules()
	{
		$rules = array(
				array('target', 'required'),
				array('target', 'safe'),
		);
	
		return CMap::mergeArray(parent::rules(), $rules);
	}
	
	public function relations()
	{
		$relations = array(
				'pages' => array(self::MANY_MANY, 'Page', 'page_blocks(ref_block_id, ref_page_id)'),
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
			return true;
		}
	}
	
	/**
	 * list all subject of tutor
	 * (non-PHPdoc)
	 * @see CActiveRecord::afterFind()
	 */
	public function afterFind() {
		parent::afterFind();
	
		foreach ($this->pages as $value){
				
			$this->allPages .=  $value->slug.', ';
		}

		$this->allPages = substr($this->allPages, 0, strlen($this->allPages)-2);
	}
}