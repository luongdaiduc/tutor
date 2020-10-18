<?php
class MailCommand extends CConsoleCommand
{
	public function actionSendMail($host)
	{		
		$this->config($host);
		
		$queues = Queue::model()->findAll('status = ?', array(Queue::PENDING));
		
		if(!empty($queues))
		{
			foreach ($queues as $queue)
			{
				//sender's information
				$from = array('name'=>$queue->sender_name, 'email'=>$queue->sender_email);
				
				//recipient's information
				$to = array('name'=>$queue->recipient_name, 'email'=>$queue->recipient_email);
				
				$subject = $queue->title;
				$message = $queue->message;
				
				MailHelper::sendMail($from, $to, $subject, $message);
				
				//update queue's status
				$queue->status = Queue::SUCCESS;
				
				$queue->active_db = Queue::model()->active_db;
				
				$queue->save();
			}
		}
	}
	
	/**
	 * notify enhanced or premium account close expire
	 * @param string $host
	 */
	public function actionNotifyExpireAccount($host)
	{
		$this->config($host);
		
		$accounts = Account::model()->findAll('role = ? AND t.status = ?', array(Account::TUTOR, Account::ACTIVE));
		
		if(!empty($accounts))
		{
			foreach ($accounts as $account)
			{
				$name = $account->first_name . ' ' . $account->last_name;
				$email = $account->email;
				
				//check enhanced account
				if($account->is_enhance == Account::ENHANCE)
				{
					$this->checkExpire($account->enhance_expire, $email, $name, 'silver', $host);
				}
				
				//check premium account
				if($account->isPremium($account->id))
				{
					$premium_accounts = TutorPremium::model()->findAll('ref_account_id = ?', array($account->id));
					
					if(!empty($premium_accounts))
					{
						foreach ($premium_accounts as $premium_account)
						{
							$this->checkExpire($premium_account->expire_date, $email, $name, 'gold', $host, $premium_account->ref_subject_id);
						}
					}
					
				}
			}
		}
	}
	
	/**
	 * check account close expire and send notify mail
	 * @param integer $expire_day
	 * @param string $email
	 * @param string $name
	 * @param integer $account_type
	 * @param integer $ref_subject_id
	 */
	public function checkExpire($expire_day, $email, $name, $account_type, $host, $ref_subject_id = NULL)
	{
		$settings = Setting::getSettingCache();
	
		//10 days before expire day
		$notify_day = strtotime('-' . $settings['notify_expire_day'] . ' days', $expire_day);

		if(strtotime(date('Y-m-d H:i:s')) >= $notify_day)
		{
			//calculate the remain day of account
			$now = new DateTime(date('Y-m-d'));
			$expire_day = new DateTime(date('Y-m-d', $expire_day));

			$interval = $expire_day->diff($now);
			
			//remain day of account
			$remain_day = $interval->d;

			$alert_remain = '';
		
			if($remain_day == $settings['notify_expire_day'] || $remain_day == 0)
			{
				$alert_remain = $remain_day > 0 ? 'in the next ' . $remain_day . ' days' : ' today';
				
				if($account_type == 'gold')
				{
					$subject = Subject::model()->findByPk($ref_subject_id);
					
					if(!empty($subject))
					{
						$params = array('name'=>$name, 'account_type'=>$account_type, 'remain'=>$alert_remain, 'subject'=>$subject->name);
					
						list($content, $title) = MailHelper::parseTemplate('notify_expire_gold_account', $params);
						
						$this->saveQueue($settings['no_reply_name'], $settings['no_reply_address'], $name, $email, $title, $content, $host);
					}
					
				}
				else 
				{
					$params = array('name'=>$name, 'account_type'=>$account_type, 'remain'=>$alert_remain);
					
					list($content, $title) = MailHelper::parseTemplate('notify_expire_account', $params);
					
					$this->saveQueue($settings['no_reply_name'], $settings['no_reply_address'], $name, $email, $title, $content, $host);
				}
			
			}
			
		}
	}
	
	/**
	 * 
	 * @param string $sender_name
	 * @param string $sender_email
	 * @param string $recipient_name
	 * @param string $recipient_email
	 * @param string $title
	 * @param string $content
	 * @param string $host
	 */
	public function saveQueue($sender_name, $sender_email, $recipient_name, $recipient_email, $title, $content, $host)
	{
		//save queue mail
		$queue = new Queue();
		
		$active_db = Queue::model()->active_db;
		$queue->active_db = $active_db;
		
		$queue->sender_name = $sender_name; 
		$queue->sender_email = $sender_email; 
		$queue->recipient_name = $recipient_name; 
		$queue->recipient_email = $recipient_email; 
		$queue->title = $title;
		$queue->message = $content;

		$queue->save();
	}
	
	/**
	 * active database and change cache key prefix based on host
	 * @param string $host
	 */
	public function config($host)
	{
		$trunk_root = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';
		$datas = include($trunk_root . DIRECTORY_SEPARATOR . 'multisite' . DIRECTORY_SEPARATOR . 'domains.php');
		
		foreach ($datas as $data)
		{
			//local
			$short_domain = $data['domain'];
			
			if($short_domain == $host)
			{
				Queue::model()->active_db = 'db_' . $data['db_name'];
				Account::model()->active_db = 'db_' . $data['db_name'];
				Subject::model()->active_db = 'db_' . $data['db_name'];
				TutorPremium::model()->active_db = 'db_' . $data['db_name'];
				Setting::model()->active_db = 'db_' . $data['db_name'];
				TutorSubject::model()->active_db = 'db_' . $data['db_name'];
				
				Yii::app()->cache->keyPrefix = $short_domain;
			}
		}
		
// 		switch ( strtolower($host))
// 		{
// 			case 'www.melbournetutor.org':
// 				Queue::model()->active_db = 'db_melbourne';
// 				Account::model()->active_db = 'db_melbourne';
// 				Subject::model()->active_db = 'db_melbourne';
// 				TutorPremium::model()->active_db = 'db_melbourne';
// 				Setting::model()->active_db = 'db_melbourne';
// 				TutorSubject::model()->active_db = 'db_melbourne';
				
// 				Yii::app()->cache->keyPrefix = 'melbourne';
		
// 				break;
		
// 			case 'www.sydneytutor.org':
// 				Queue::model()->active_db = 'db_sydney';
// 				Account::model()->active_db = 'db_sydney';
// 				Subject::model()->active_db = 'db_sydney';
// 				TutorPremium::model()->active_db = 'db_sydney';
// 				Setting::model()->active_db = 'db_sydney';
// 				TutorSubject::model()->active_db = 'db_sydney';
				
// 				Yii::app()->cache->keyPrefix = 'sydney';
		
// 				break;
				
// 			case 'www.dev.melbournetutor.org':
// 				Queue::model()->active_db = 'db_dev';
// 				Account::model()->active_db = 'db_dev';
// 				Subject::model()->active_db = 'db_dev';
// 				TutorPremium::model()->active_db = 'db_dev';
// 				Setting::model()->active_db = 'db_dev';
// 				TutorSubject::model()->active_db = 'db_dev';
			
// 				Yii::app()->cache->keyPrefix = 'dev';
			
// 				break;
		
// 			default:
// 				Queue::model()->active_db = 'db_melbourne';
// 				Account::model()->active_db = 'db_melbourne';
// 				Subject::model()->active_db = 'db_melbourne';
// 				TutorPremium::model()->active_db = 'db_melbourne';
// 				Setting::model()->active_db = 'db_melbourne';
// 				TutorSubject::model()->active_db = 'db_melbourne';
				
// 				Yii::app()->cache->keyPrefix = 'melbourne';
// 		}
	}
	
}