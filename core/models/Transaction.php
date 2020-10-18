<?php
class Transaction extends BaseTransaction
{
	const COMPLETED = 1;
	
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
				'account' => array(self::BELONGS_TO, 'Account', 'ref_account_id'),
				);
	
		return CMap::mergeArray(parent::relations(), $relations);
	}
	
	public function rules()
	{
		$rules = array(
				array('txn_id', 'unique'),
				);
	
		return CMap::mergeArray(parent::rules(), $rules);
	}
	
}