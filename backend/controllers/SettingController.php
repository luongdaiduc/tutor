<?php
class SettingController extends Controller
{
	public function actionHome()
	{
		$search_km_choices = Setting::model()->find('name ="search_km_choices"');
		$search_feedback_choices = Setting::model()->find('name ="search_feedback_choices"');
		
		$city = Setting::model()->find('name = "city"');
		$site_title = Setting::model()->find('name = "site_title"');
		$language = Setting::model()->find('name = "language"');
		
		$currency = Setting::model()->find('name = "currency"');
		$default_currency_symbol = Setting::model()->find('name = "default_currency_symbol"');
		$short_date_format = Setting::model()->find('name = "short_date_format"');
		$long_date_format = Setting::model()->find('name = "long_date_format"');
		
		$meta_keywords = Setting::model()->find('name = "meta_keywords"');
		$meta_description = Setting::model()->find('name = "meta_description"');
		$google_analytics_account = Setting::model()->find('name = "google_analytics_account"');
		
		$google_api_key = Setting::model()->find('name = "google_api_key"');
		$google_track_code = Setting::model()->find('name = "google_track_code"');
		$google_api_secret = Setting::model()->find('name = "google_api_secret"');
		$facebook_api_key = Setting::model()->find('name = "facebook_api_key"');
		$facebook_api_secret = Setting::model()->find('name = "facebook_api_secret"');
		$twitter_api_key = Setting::model()->find('name = "twitter_api_key"');
		$twitter_api_secret = Setting::model()->find('name = "twitter_api_secret"');
		
		if(isset($_POST) && !empty($_POST))
		{
			$_search_km_choices = app()->request->getPost('search_km_choices', false);
			
			if($_search_km_choices)
			{
				//save only integer data
				$_search_km_choices = explode(',', $_search_km_choices);
				$arrs = array();
				
				foreach ($_search_km_choices as $_search_km_choice)
				{
					if(is_numeric($_search_km_choice))
					{
						$arrs[] = $_search_km_choice;
					}
				}
				
				asort($arrs);
				$arrs = implode(',', $arrs);
				
				$search_km_choices->value = $arrs;
				$search_km_choices->save();
			}

			$_search_feedback_choices = app()->request->getPost('search_feedback_choices', false);
			
			if($_search_feedback_choices)
			{
				//save only integer data
				$_search_feedback_choices = explode(',', $_search_feedback_choices);
				$arrs = array();
				
				foreach ($_search_feedback_choices as $_search_feedback_choice)
				{
					if(is_numeric($_search_feedback_choice))
					{
						$arrs[] = $_search_feedback_choice;
					}
				}
				
				asort($arrs);
				$arrs = implode(',', $arrs);
				
				$search_feedback_choices->value = $arrs;
				$search_feedback_choices->save();
			}
			
			$_city = app()->request->getPost('city', false);
				
			if($_city)
			{
				$city->value = $_city;
				$city->save();
			
			}
			
			$_site_title = app()->request->getPost('site_title', false);
			
			if($_site_title)
			{
				$site_title->value = $_site_title;
				$site_title->save();
				
			}
			
			$_language = app()->request->getPost('language', false);
				
			if($_language)
			{
				$language->value = $_language;
				$language->save();
			
			}
			
			$_currency = app()->request->getPost('currency', false);
				
			if($_currency)
			{
				$currency->value = $_currency;
				$currency->save();
			
			}
			
			$_default_currency_symbol = app()->request->getPost('default_currency_symbol', false);
			
			if($_default_currency_symbol)
			{
				$default_currency_symbol->value = $_default_currency_symbol;
				$default_currency_symbol->save();
					
			}
			
			$_short_date_format = app()->request->getPost('short_date_format', false);
			
			if($_short_date_format)
			{
				$short_date_format->value = $_short_date_format;
				$short_date_format->save();
			}
			
			$_long_date_format = app()->request->getPost('long_date_format', false);
			
			if($_long_date_format)
			{
				$long_date_format->value = $_long_date_format;
				$long_date_format->save();
			}
			
			$_meta_keywords = app()->request->getPost('meta_keywords', false);
				
			if($_meta_keywords)
			{
				$meta_keywords->value = $_meta_keywords;
				$meta_keywords->save();
			}
			
			$_meta_description = app()->request->getPost('meta_description', false);
				
			if($_meta_description)
			{
				$meta_description->value = $_meta_description;
				$meta_description->save();
			}
			
			$_google_analytics_account = app()->request->getPost('google_analytics_account', false);
			
			if($_google_analytics_account)
			{
				$google_analytics_account->value = $_google_analytics_account;
				$google_analytics_account->save();
			}
					
			$_google_api_key = app()->request->getPost('google_api_key', false);
	
			if($_google_api_key)
			{
				$google_api_key->value = $_google_api_key;
				$google_api_key->save();
			}
			
			$_google_track_code = app()->request->getPost('google_track_code', false);
			
			if($_google_track_code)
			{
				$google_track_code->value = $_google_track_code;
				$google_track_code->save();
			}
			
			$_google_api_secret = app()->request->getPost('google_api_secret', false);
			
			if($_google_api_secret)
			{
				$google_api_secret->value = $_google_api_secret;
				$google_api_secret->save();
			}
			
			$_facebook_api_key = app()->request->getPost('facebook_api_key', false);
			
			if($_facebook_api_key)
			{
				$facebook_api_key->value = $_facebook_api_key;
				$facebook_api_key->save();
			}
			
			$_facebook_api_secret = app()->request->getPost('facebook_api_secret', false);
			
			if($_facebook_api_secret)
			{
				$facebook_api_secret->value = $_facebook_api_secret;
				$facebook_api_secret->save();
			}
			
			$_twitter_api_key = app()->request->getPost('twitter_api_key', false);
			
			if($_twitter_api_key)
			{
				$twitter_api_key->value = $_twitter_api_key;
				$twitter_api_key->save();
			}
			
			$_twitter_api_secret = app()->request->getPost('twitter_api_secret', false);
			
			if($_twitter_api_secret)
			{
				$twitter_api_secret->value = $_twitter_api_secret;
				$twitter_api_secret->save();
			}
			
			//clear cache
			app()->cache->delete(app()->params['cacheSettingsId']);
			
			app()->user->setFlash('message', 'Settings have been saved.');
		}

		$this->render('home', array(
				'kms'=>$search_km_choices->value,
// 				'reviews'=>$search_review_choices->value,
				'feedbacks'=>$search_feedback_choices->value,
				
				'city'=>$city,
				'site_title'=>$site_title,
				'language'=>$language,
				
				'currency'=>$currency,
				'default_currency_symbol'=>$default_currency_symbol,
				'short_date_format'=>$short_date_format,
				'long_date_format'=>$long_date_format,
				
				'meta_keywords'=>$meta_keywords,
				'meta_description'=>$meta_description,
				'google_analytics_account'=>$google_analytics_account,
				
				'google_api_key'=>$google_api_key,
				'google_track_code'=>$google_track_code,
				'google_api_secret'=>$google_api_secret,
				'facebook_api_key'=>$facebook_api_key,
				'facebook_api_secret'=>$facebook_api_secret,
				'twitter_api_key'=>$twitter_api_key,
				'twitter_api_secret'=>$twitter_api_secret,
				
				'message'=>app()->user->getFlash('message'),
				));
	}
	
	/**
	 * setting email
	 */
	public function actionMail()
	{
		$mail_server = Setting::model()->find('name = "mail_server"');
		$username = Setting::model()->find('name = "username"');
		$password = Setting::model()->find('name = "password"');
		$port = Setting::model()->find('name = "port"');
		$ssl = Setting::model()->find('name = "ssl"');
		
		$no_reply_name = Setting::model()->find('name = "no_reply_name"');
		$no_reply_address = Setting::model()->find('name = "no_reply_address"');
		$reply_name = Setting::model()->find('name = "reply_name"');
		$reply_address = Setting::model()->find('name = "reply_address"');
		
		$notify_expire_day = Setting::model()->find('name = "notify_expire_day"');
		
		if(isset($_POST) && !empty($_POST))
		{
			$_mail_server = app()->request->getPost('mail_server', false);
			
			if($_mail_server)
			{
				$mail_server->value = $_mail_server;
				$mail_server->save();
			}
			
			$_username = app()->request->getPost('username', false);
			
			if($_username)
			{
				$username->value = $_username;
				$username->save();
			}
			
			$_password = app()->request->getPost('password', false);
			
			if($_password)
			{
				$password->value = $_password;
				$password->save();
			}
			
			$_port = app()->request->getPost('port', false);
			
			if($_port)
			{
				$port->value = $_port;
				$port->save();
			}
			
			$_ssl = app()->request->getPost('ssl', false);
			
			if($_ssl)
			{
				$ssl->value = 1;
				$ssl->save();
			}
			else 
			{
				$ssl->value = 0;
				$ssl->save();
			}
			
			$_no_reply_name = app()->request->getPost('no_reply_name', false);
			
			if($_no_reply_name)
			{
				$no_reply_name->value = $_no_reply_name;
				$no_reply_name->save();
			}
			
			$_no_reply_address = app()->request->getPost('no_reply_address', false);
			
			if($_no_reply_address)
			{
				$no_reply_address->value = $_no_reply_address;
				$no_reply_address->save();
			}
			
			$_reply_name = app()->request->getPost('reply_name', false);
			
			if($_reply_name)
			{
				$reply_name->value = $_reply_name;
				$reply_name->save();
			}
			
			$_reply_address = app()->request->getPost('reply_address', false);
			
			if($_reply_address)
			{
				$reply_address->value = $_reply_address;
				$reply_address->save();
			}
			
			$_notify_expire_day = app()->request->getPost('notify_expire_day', false);
				
			if($_notify_expire_day)
			{
				$notify_expire_day->value = $_notify_expire_day;
				$notify_expire_day->save();
			}

			//clear cache
			app()->cache->delete(app()->params['cacheSettingsId']);
			
			app()->user->setFlash('message', 'Settings have been saved.');
		}
		
		$this->render('mail', array(
				'mail_server'=>$mail_server,
				'username'=>$username,
				'password'=>$password,
				'port'=>$port,
				'ssl'=>$ssl,
				'no_reply_name'=>$no_reply_name,
				'no_reply_address'=>$no_reply_address,
				'reply_name'=>$reply_name,
				'reply_address'=>$reply_address,
				'notify_expire_day'=>$notify_expire_day,
				'message'=>app()->user->getFlash('message'),
				));
	}
	
	/**
	 * setting count
	 */
	public function actionCount()
	{
		$count_latest_tutor = Setting::model()->find('name = "count_latest_tutor"');
		$count_search_result = Setting::model()->find('name = "count_search_result"');
		$count_browse_tutor = Setting::model()->find('name = "count_browse_tutor"');
		
		$summary_minimum = Setting::model()->find('name = "summary_minimum"');
		$summary_maximum = Setting::model()->find('name = "summary_maximum"');
		$description_minimum = Setting::model()->find('name = "description_minimum"');
		$description_maximum = Setting::model()->find('name = "description_maximum"');
		
		if(isset($_POST) && !empty($_POST))
		{
			$_count_latest_tutor = app()->request->getPost('count_latest_tutor', false);
				
			if($_count_latest_tutor)
			{
				$count_latest_tutor->value = $_count_latest_tutor;
				$count_latest_tutor->save();
			}
				
			$_count_search_result = app()->request->getPost('count_search_result', false);
				
			if($_count_search_result)
			{
				$count_search_result->value = $_count_search_result;
				$count_search_result->save();
			}
				
			$_count_browse_tutor = app()->request->getPost('count_browse_tutor', false);
				
			if($_count_browse_tutor)
			{
				$count_browse_tutor->value = $_count_browse_tutor;
				$count_browse_tutor->save();
			}
			
			$_summary_minimum = app()->request->getPost('summary_minimum', false);
			
			if($_summary_minimum)
			{
				$summary_minimum->value = $_summary_minimum;
				$summary_minimum->save();
			}
			
			$_summary_maximum = app()->request->getPost('summary_maximum', false);
				
			if($_summary_maximum)
			{
				$summary_maximum->value = $_summary_maximum;
				$summary_maximum->save();
			}
			
			$_description_minimum = app()->request->getPost('description_minimum', false);
				
			if($_description_minimum)
			{
				$description_minimum->value = $_description_minimum;
				$description_minimum->save();
			}
			
			$_description_maximum = app()->request->getPost('description_maximum', false);
				
			if($_description_maximum)
			{
				$description_maximum->value = $_description_maximum;
				$description_maximum->save();
			}
				
			//clear cache
			app()->cache->delete(app()->params['cacheSettingsId']);
				
			app()->user->setFlash('message', 'Settings have been saved.');
		}
		
		$this->render('count', array(
				'count_latest_tutor'=>$count_latest_tutor,
				'count_search_result'=>$count_search_result,
				'count_browse_tutor'=>$count_browse_tutor,
				
				'summary_minimum'=>$summary_minimum,
				'summary_maximum'=>$summary_maximum,
				'description_minimum'=>$description_minimum,
				'description_maximum'=>$description_maximum,
				
				'message'=>app()->user->getFlash('message'),
				));
	}
	
	/**
	 * setting video
	 */
	public function actionVideo()
	{
		$video_enable = Setting::model()->find('name = "video_enable"');
		$video_player_width = Setting::model()->find('name = "video_player_width"');
		$video_player_length = Setting::model()->find('name = "video_player_length"');
		$video_summary_minimum = Setting::model()->find('name = "video_summary_minimum"');
		$video_summary_maximum = Setting::model()->find('name = "video_summary_maximum"');
		
		if(isset($_POST) && !empty($_POST))
		{
			$_video_enable = app()->request->getPost('video_enable', false);
				
			if($_video_enable)
			{
				$video_enable->value = 1;
				$video_enable->save();
			}
			else
			{
				$video_enable->value = 0;
				$video_enable->save();
			}
			
			$_video_player_width = app()->request->getPost('video_player_width', false);
				
			if($_video_player_width)
			{
				$video_player_width->value = $_video_player_width;
				$video_player_width->save();
			}
				
			$_video_player_length = app()->request->getPost('video_player_length', false);
				
			if($_video_player_length)
			{
				$video_player_length->value = $_video_player_length;
				$video_player_length->save();
			}
				
			$_video_summary_minimum = app()->request->getPost('video_summary_minimum', false);
				
			if($_video_summary_minimum)
			{
				$video_summary_minimum->value = $_video_summary_minimum;
				$video_summary_minimum->save();
			}
				
			$_video_summary_maximum = app()->request->getPost('video_summary_maximum', false);
				
			if($_video_summary_maximum)
			{
				$video_summary_maximum->value = $_video_summary_maximum;
				$video_summary_maximum->save();
			}
				
			//clear cache
			app()->cache->delete(app()->params['cacheSettingsId']);
				
			app()->user->setFlash('message', 'Settings have been saved.');
		}
		
		$this->render('video', array(
				'video_enable'=>$video_enable,
				'video_player_width'=>$video_player_width,
				'video_player_length'=>$video_player_length,
				'video_summary_minimum'=>$video_summary_minimum,
				'video_summary_maximum'=>$video_summary_maximum,
				'message'=>app()->user->getFlash('message'),
		));
	}
	
	
	/**
	 * setting invoice
	 */
	public function actionInvoice()
	{
		//company info
		$invoice_company = Setting::model()->find('name = "invoice_company"');
		$invoice_address = Setting::model()->find('name = "invoice_address"');
		$invoice_suburb = Setting::model()->find('name = "invoice_suburb"');
		$invoice_state = Setting::model()->find('name = "invoice_state"');
		$invoice_postcode = Setting::model()->find('name = "invoice_postcode"');
		$invoice_footer = Setting::model()->find('name = "invoice_footer"');
		
		//GST
		$gst_enable = Setting::model()->find('name = "gst_enable"');
		$gst_rate = Setting::model()->find('name = "gst_rate"');
	
		//paypal info
		$paypal_sandbox_mode = Setting::model()->find('name = "paypal_sandbox_mode"');
		$paypal_email = Setting::model()->find('name = "paypal_email"');
		$paypal_return_text = Setting::model()->find('name = "paypal_return_text"');
	
		if(isset($_POST) && !empty($_POST))
		{
			$_invoice_company = app()->request->getPost('invoice_company', false);
				
			if($_invoice_company)
			{
				$invoice_company->value = $_invoice_company;
				$invoice_company->save();
			}
			
			$_invoice_address = app()->request->getPost('invoice_address', false);
			
			if($_invoice_address)
			{
				$invoice_address->value = $_invoice_address;
				$invoice_address->save();
			}
			
			$_invoice_suburb = app()->request->getPost('invoice_suburb', false);
				
			if($_invoice_suburb)
			{
				$invoice_suburb->value = $_invoice_suburb;
				$invoice_suburb->save();
			}
			
			$_invoice_state = app()->request->getPost('invoice_state', false);
		
			if($_invoice_state)
			{
				$invoice_state->value = $_invoice_state;
				$invoice_state->save();
			}
			
			$_invoice_postcode = app()->request->getPost('invoice_postcode', false);
			
			if($_invoice_postcode)
			{
				$invoice_postcode->value = $_invoice_postcode;
				$invoice_postcode->save();
			}
			
			$_invoice_footer = app()->request->getPost('invoice_footer', false);
				
			if($_invoice_footer)
			{
				$invoice_footer->value = $_invoice_footer;
				$invoice_footer->save();
			}
			
			$_gst_enable = app()->request->getPost('gst_enable', false);
			
			if($_gst_enable)
			{
				$gst_enable->value = 1;
				$gst_enable->save();
			}
			else
			{
				$gst_enable->value = 0;
				$gst_enable->save();
			}
			
			$_gst_rate = app()->request->getPost('gst_rate', false);
				
			if($_gst_rate)
			{
				$gst_rate->value = intval($_gst_rate);
				$gst_rate->save();
			}
			
			$_paypal_sandbox_mode = app()->request->getPost('paypal_sandbox_mode', false);
				
			if($_paypal_sandbox_mode)
			{
				$paypal_sandbox_mode->value = 1;
				$paypal_sandbox_mode->save();
			}
			else
			{
				$paypal_sandbox_mode->value = 0;
				$paypal_sandbox_mode->save();
			}

			$_paypal_email = app()->request->getPost('paypal_email', false);
				
			if($_paypal_email)
			{
				$paypal_email->value = $_paypal_email;
				$paypal_email->save();
			}
			
			$_paypal_return_text = app()->request->getPost('paypal_return_text', false);
			
			if($_paypal_return_text)
			{
				$paypal_return_text->value = $_paypal_return_text;
				$paypal_return_text->save();
			}
			
			//clear cache
			app()->cache->delete(app()->params['cacheSettingsId']);
				
			app()->user->setFlash('message', 'Settings have been saved.');
		}
		
		$this->render('invoice', array(
				'invoice_company'=>$invoice_company,
				'invoice_address'=>$invoice_address,
				'invoice_suburb'=>$invoice_suburb,
				'invoice_state'=>$invoice_state,
				'invoice_postcode'=>$invoice_postcode,
				'invoice_footer'=>$invoice_footer,
				
				'gst_enable'=>$gst_enable,
				'gst_rate'=>$gst_rate,
				
				'paypal_sandbox_mode'=>$paypal_sandbox_mode,
				'paypal_email'=>$paypal_email,
				'paypal_return_text'=>$paypal_return_text,
				
				'message'=>app()->user->getFlash('message'),
		));
		
	}
	
	/**
	 * test send mail
	 */
	public function actionTestMail()
	{
		$name = CPropertyValue::ensureString(request()->getParam('name'));
		$email = CPropertyValue::ensureString(request()->getParam('email'));
		
		$settings = $this->settings;
		
		//sender's information
		$from = array('name'=>$settings['no_reply_name'], 'email'=>$settings['no_reply_address']);
		
		//recipient's information
		$to = array('name'=>$name, 'email'=>$email);
		
		$subject = $settings['site_title'] . ' - Test Mail';
		$message = 'Test whether send mail function working or not.';
		
		MailHelper::sendMail($from, $to, $subject, $message);
		
		echo json_encode(array('success'=>true));
	}
}