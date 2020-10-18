<?php
/**
 * Daily alert to admin total unread messages
 * @author Nam Long Software
 *
 */
class AlertCommand extends CConsoleCommand
{
	public function run($args)
	{
		$content = array();
		
		$dbList = $this->getDbList();
		
		foreach ($dbList as $db => $site_url)
		{
			$total = Yii::app()->$db->createCommand()
				->select('count(*)')
				->from('messages') //Message::model()->tableName()
				->where('is_read = '. Message::UNREAD)
				->queryScalar();

			if($total > 0) {
				$setting = Yii::app()->$db->createCommand()
						->select('name, value')
						->from('settings') //Setting::model()->tableName()
						->where('name = \'site_title\'')
						->queryRow();
				
				$content[] = '<a href="'. $site_url .'/message">'. $setting['value'] .'</a> - '. $total .' unread message'. ($total > 1 ? 's':'');
			}
		}
		
		if(!empty($content))
		{
			$message = implode('<br/>', $content);
			$subject = 'Daily email summary';
			$from = array('name'=>'MelbourneTutor', 'email'=>'noreply@melbournetutor.org');
			$to = array('name'=>'Lester Chumbley', 'email'=>'lester.chumbley@hotmail.com');
			
			MailHelper::sendMail($from, $to, $subject, $message);
		}
	}
	
	/**
	 * Get database list
	 * 
	 * @return array
	 */
	private function getDbList()
	{
		$trunk_root = dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';
		$datas = include($trunk_root . DIRECTORY_SEPARATOR . 'multisite' . DIRECTORY_SEPARATOR . 'domains.php');
		$array = array();
		
		foreach($datas as $data)
		{
			if($data['domain'] != 'melbournetutor.com')
			{
				$array['db_' . $data['db_name']]= 'http://admin.' . $data['domain'];
			}
			
		}
		
		return $array;
	}
}