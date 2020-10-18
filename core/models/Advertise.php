<?php
class Advertise extends BaseAdvertise
{
	public $allDeliveries = '';
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function rules()
	{
		$rules = array(
			array('ref_account_id, title, summary, detail, audiences', 'required', 'message'=>'{attribute} ' . Common::translate('validation', 'cannot be blank')),
			array('domain', 'unique', 'on'=>'create', 'message'=>Common::translate('validation', 'This domain has already been taken')),
			array('domain', 'required', 'on'=>'create', 'message'=>'{attribute} ' . Common::translate('validation', 'cannot be blank')),
			array('domain', 'match', 'pattern'=>'/^[\w\-]+$/', 'on'=>'create', 'message'=>Common::translate('validation', 'Domain is invalid')),
			array('domain', 'notAdmin'),
		);
	
		return CMap::mergeArray(parent::rules(), $rules);
	}
	
	public function relations()
	{
		$relations = array(
				'deliveries' => array(self::MANY_MANY, 'Delivery', 'tutor_deliveries(ref_account_id, ref_delivery_id)'),
				'accounts' => array(self::BELONGS_TO, 'Account', 'ref_account_id'),
		);
	
		return CMap::mergeArray(parent::relations(), $relations);
	}
	
	public function attributeLabels()
	{
		$labels = array(
				'title' => Common::translate('register', 'Title'),
				'summary' => Common::translate('register', 'Summary'),
				'detail' => Common::translate('register', 'Detail'),
				'audiences' => Common::translate('register', 'Audience'),
				'domain' => Common::translate('register', 'Domain'),
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
	
	public function afterFind() {
		parent::afterFind();

		foreach ($this->deliveries as $value){
			$this->allDeliveries .=  $value->name.', ';
		}
	
		$this->allDeliveries = substr($this->allDeliveries, 0, strlen($this->allDeliveries)-2);
	}
	
	public function afterValidate()
	{
		parent::afterValidate();
		
		$summary = $this->summary;
		$description = $this->detail;
		
		$settings = app()->controller->settings;
		
		if(strlen($summary) < $settings['summary_minimum'])
		{
			$this->addError('summary', Common::translate('validation', 'Minimum {type} length is {length} characters', array('{type}'=>'summary', '{length}'=> $settings['summary_minimum'])));
		}
		
		if(strlen($summary) > $settings['summary_maximum'])
		{
			$this->addError('summary', Common::translate('validation', 'Maximum {type} length is {length} characters', array('{type}'=>'summary', '{length}'=> $settings['summary_maximum'])));
		}
		
		if(strlen($description) < $settings['description_minimum'])
		{
			$this->addError('detail', Common::translate('validation', 'Minimum {type} length is {length} characters', array('{type}'=>'description', '{length}'=> $settings['description_minimum'])));
		}
		
		if(strlen($description) > $settings['description_maximum'])
		{
			$this->addError('detail', Common::translate('validation', 'Maximum {type} length is {length} characters', array('{type}'=>'description', '{length}'=> $settings['description_maximum'])));
		}
	}
	
	public function notAdmin($attribute,$params)
	{
		if($this->domain == 'admin')
			$this->addError('domain', Common::translate('validation', 'This domain has already been taken'));
	}
}