<?php
class MailHelper 
{
	static protected $params;
	
	/**
	 * @return mailer
	 */
	private static function getMailer()
	{
		$sm = new XSwiftMailer();
		$mailer = $sm->getMailer();
	
		return $mailer;
	}
	
	public static function sendMail($from, $to, $subject, $message)
	{
		try {
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'To: '. $to['name'] .' <'. $to['email'] .'>'. "\r\n";
			$headers .= 'From: ' . $from['name'] . ' <'. $from['email'] .'>'. "\r\n";

			mail($to['email'], $subject, $message, $headers);
		}
		catch (Exception $e) {
			Yii::log($e->message, 'error');
		}
	}
	
	/**
	 * send activate url to user when register successfully
	 * @param string $name
	 * @param string $url
	 * @param string $email
	 */
	public static function signUp($name, $url, $email)
	{
		$params = array('name'=>$name, 'activateUrl'=>$url);
		
		list($content, $subject) = self::parseTemplate('sign_up', $params);
	
		self::sendMail(
				array('name'=>app()->controller->settings['no_reply_name'], 'email'=>app()->controller->settings['no_reply_address']),
				array('name'=>$name, 'email'=>$email),
				$subject,
				$content);
	}
	
	/**
	 * Parse an email template and replace variables with values provided in params
	 *
	 * @param mixed $template relative template path, from resource/emails folder
	 * @param mixed $params associative array of values to fill the template
	 * @return mixed
	 */
	public static function parseTemplate($template, $params){
		self::$params = $params;
		
		$body = Template::model()->find('name = ?', array($template));
		
		if(!empty($body))
		{
			//subject for mail
			$subject = $body->subject;
			
			$body = $body->content;
			
			$body = preg_replace_callback('/\%[\w|-]*\%/',
					array('MailHelper','replaceParams'),
					$body);
			
			return array($body, $subject);
		}
		
	}
	
	/**
	 * This function is solely used by the parseTemplate method
	 *
	 * @param mixed $matches
	 * @return EmailUtil
	 */
	static protected function replaceParams($matches){
		$var = substr($matches[0],1,strlen($matches[0])-2);
		return self::$params[$var];
	}
}