<?php
class Subscription extends BaseSubscription
{
	const ENHANCE = 1;
	const PREMIUM = 2;
	const PUBLISHED = 1;
	const DRAFT = 0;
	
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
			array('title', 'required'),
			array('amount', 'numerical', 'integerOnly'=>true),
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
			else
				$this->updated = date('Y-m-d H:i:s');
			return true;
		}
	}
	
	/**
	 * find all active enhance item, used for drop down list in upgrade tutor account
	 */
	public function getEnhance()
	{
		$criteria = new CDbCriteria();
		
		$criteria->condition = 'type = ? and status = ?';
		$criteria->params = array(self::ENHANCE, self::PUBLISHED);
		
		$enhance_subscriptions = Subscription::model()->findAll($criteria);
		
		$choices = array();
		if(!empty($enhance_subscriptions))
		{
			foreach ($enhance_subscriptions as $idx => $enhance_subscription)
			{
				$choices[$enhance_subscription->id] = $enhance_subscription->period . ' @ ' . Common::formatCurrency($enhance_subscription->amount) ;
			}
		}
		
		return $choices;
	}
	
	/**
	 * find all active premium item, used for drop down list in upgrade tutor account
	 */
	public function getPremium()
	{
		$criteria = new CDbCriteria();
	
		$criteria->condition = 'type = ? and status = ?';
		$criteria->params = array(self::PREMIUM, self::PUBLISHED);
	
		$premium_subscriptions = Subscription::model()->findAll($criteria);
	
		$choices = array();
		if(!empty($premium_subscriptions))
		{
			foreach ($premium_subscriptions as $premium_subscription)
			{
				$choices[$premium_subscription->id . '-' . $premium_subscription->amount] = $premium_subscription->period . ' @ ' . Common::formatCurrency($premium_subscription->amount);
			}
		}
		
		return $choices;
	}
	
	/**
	 * get paypal link, used in upgrade enhance tutor account
	 * @param integer $subcripstion_id
	 * @param integer $account_id
	 * @param integer $account_type
	 */
	public function getPaypalLink($subcripstion_id, $account_id, $account_type)
	{
		$subcripstion = Subscription::model()->findByPk($subcripstion_id);
	
		if(!empty($subcripstion))
		{
			$p = new paypal_ipn();             // initiate an instance of the class
			
			$p->paypal_url = app()->controller->settings['paypal_sandbox_mode'] == 1 ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';   // testing paypal url
			//$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url
			
			// setup a variable for this script (ie: 'http://www.micahcarrick.com/paypal.php')
			$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			
			$p->add_field('business', app()->controller->settings['paypal_email']);
			$p->add_field('cbt', app()->controller->settings['paypal_return_text']);
			
			//live site
			$p->add_field('return', app()->params['siteUrl'] . url('/tutor/paypal'));
			$p->add_field('cancel_return', app()->params['siteUrl'] . url('/tutor/paypal'));
			$p->add_field('notify_url', app()->params['siteUrl'] . url('/tutor/ipn'));
			
			//local
// 					$p->add_field('return', 'http://front.tutor.com' . url('/tutor/paypal'));
// 					$p->add_field('cancel_return', 'http://front.tutor.com' . url('/tutor/paypal'));
// 					$p->add_field('notify_url', 'http://front.tutor.com' . url('/tutor/ipn'));
			
			$p->add_field('item_name', 'Silver Package');
			$p->add_field("item_number",$subcripstion_id);
			$p->add_field('amount', $subcripstion->amount);
			$p->add_field('custom', $account_id);
			$p->add_field('currency_code', app()->controller->settings['currency']);
			// 		$p->add_field('tax','1.5');
			
			return $p->submit_paypal_post(); // submit the fields to paypal
		}
		
	}
	
	/**
	 * get paypal link, used in upgrade premium account
	 * @param string $subcripstion_ids
	 * @param integer $account_id
	 * @param integer $total
	 */
	public function getPremiumLink($subcripstion_subject_ids, $account_id, $total)
	{
		$subcripstion_subject_ids = explode(',', $subcripstion_subject_ids);
		
		$quantity = count($subcripstion_subject_ids);
				
		$currency = app()->controller->settings['currency'];
		
		$p = new paypal_ipn();             // initiate an instance of the class
			
		$p->paypal_url = app()->controller->settings['paypal_sandbox_mode'] == 1 ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';   // testing paypal url
			
		$p->add_field('business', app()->controller->settings['paypal_email']);
		$p->add_field('cmd','_cart');
		$p->add_field('upload', 1);
		$p->add_field('cbt', app()->controller->settings['paypal_return_text']);
		
// 		live site
		$p->add_field('return', app()->params['siteUrl'] . url('/tutor/paypalPremium'));
		$p->add_field('cancel_return', app()->params['siteUrl'] . url('/tutor/paypalPremium'));
		$p->add_field('notify_url', app()->params['siteUrl'] . url('/tutor/ipnPremium'));
// 		local
// 		$p->add_field('return', 'http://front.tutor.com' . url('/tutor/paypalPremium'));
// 		$p->add_field('cancel_return', 'http://front.tutor.com' . url('/tutor/paypalPremium'));
// 		$p->add_field('notify_url', 'http://front.tutor.com' . url('/tutor/ipnPremium'));

		foreach ($subcripstion_subject_ids as $idx => $subcripstion_subject_id)
		{
			$subcripstion_subject_id = explode('-', $subcripstion_subject_id);
			
			$subcripstion_id = $subcripstion_subject_id[0];
			$subcripstion = Subscription::model()->findByPk($subcripstion_id);
			
			$subject_id = $subcripstion_subject_id[1];
			$subject = Subject::model()->findByPk($subject_id);
			
			$p->add_field('item_name_' . ($idx + 1), $subject->name . ': ' . $subcripstion->period . ' @ ' . Common::formatCurrency($subcripstion->amount));

			$p->add_field('amount_' . ($idx + 1), $subcripstion->amount);
		}
		
		$p->add_field('custom', $account_id . '-' . $total . '-' . $quantity . '+' . implode(',', $subcripstion_subject_ids));
		$p->add_field('currency_code', $currency);
		
		return $p->submit_paypal_post(); // submit the fields to paypal
	}
	
}