<?php
class Invoice extends BaseInvoice
{
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
				'accounts' => array(self::BELONGS_TO, 'Account', 'ref_account_id'),
				'transactions' => array(self::BELONGS_TO, 'Transaction', 'ref_transaction_id'),
				);
	
		return CMap::mergeArray(parent::relations(), $relations);
	}
	
	public function rules()
	{
		$rules = array(
				array('ref_transaction_id', 'unique'),
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
				$this->created = date('Y-m-d H:i:s');
			}
			return true;
		}
	}
	
	/**
	 * return invoice info in create invoice
	 * @param string $subscription_subject_ids
	 */
	public function invoiceInfo($subscription_subject_ids)
	{
		$string = '';
		$settings = app()->controller->settings;
		
		foreach ($subscription_subject_ids as $subscription_subject_id)
		{
			$subscription_subject_id = explode('-', $subscription_subject_id);
				
			$subscription_id = $subscription_subject_id[0];
			$subject_id = $subscription_subject_id[1];
			
			$subject = Subject::model()->findByPk($subject_id);
			$subscription = Subscription::model()->findByPk($subscription_id);
			
			$string .= '<tr>'
						. '<td style="width: 80%;"> ' . $subject->name . ': ' . $subscription->period . ' @ ' . Common::formatCurrency($subscription->amount) . ' </td>'
						. '<td style="text-align: right;">' . Common::formatCurrency(number_format(($subscription->amount/(1 + $settings['gst_rate']/100)), 2)) . '</td>'
						. '</tr>'; 
		}
		
		return $string;
	}
}