<?php
class AccountCommand extends CConsoleCommand
{
	public function actionDownGrade()
	{
		$accounts = Account::model()->findAll('is_enhance = ? OR is_premium = ?', array(Account::ENHANCE, Account::PREMIUM));
		
		if(!empty($accounts))
		{
			foreach ($accounts as $account)
			{
				//check enhanced's expired day
				if($account->is_enhance == Account::ENHANCE)
				{
					$expire_day = $account->enhance_expire;
	
					if(strtotime(date('Y-m-d H:i:s')) >= $expire_day)
					{
						$account->is_enhance = Account::BASIC;
						$account->enhance_start = 0;
						$account->enhance_expire = 0;
					}
				}
				
				//check premium's expired day
				if($account->is_premium == Account::PREMIUM)
				{
					$expire_day = $account->premium_expire;
				
					if(strtotime(date('Y-m-d H:i:s')) >= $expire_day)
					{
						$account->is_premium = Account::BASIC;
						$account->premium_start = 0;
						$account->premium_expire = 0;
					}
				}
				
				$account->save();
			}
		}
	}
	
}