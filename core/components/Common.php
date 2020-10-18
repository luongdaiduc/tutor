<?php
class Common
{
	public static function translate($category, $text, $params = array())
	{
		$translate_text = Yii::t($category, $text, $params, null, app()->controller->settings['language']);
		
		return $translate_text;
	}
	
	/**
	 * insert meta tag into page
	 */
	public static function insertMeta()
	{
		$settings = app()->controller->settings;
		
		//register meta description
		cs()->registerMetaTag($settings['meta_description'], 'description');
		
		//register meta keywords
		cs()->registerMetaTag($settings['meta_keywords'], 'keywords');
	}
	/**
	 * show currency symbol base on default currency symbol
	 * @param integer $value
	 */
	public static function formatCurrency($value)
	{
		$string = app()->controller->settings['default_currency_symbol'] . $value;
		
		return $string;
	}
	
	/**
	 * show account status
	 * @param integer $status
	 */
	public static function statusAccount($status)
	{
		switch ($status) {
			case Account::INACTIVE:
				return "Disabled";
				break;
			case Account::ACTIVE:
				return "Active";
				break;
			case Account::HIDE:
				return "Hide Advertise";
				break;
			case Account::AWAITING:
				return "Awaiting Activate";
				break;
		}
	}
	
	/**
	 * return link embed youtube video
	 * @param string $url
	 */
	public static function embedYoutube($url)
	{
		$video_id = explode('watch?v=', $url);
		$video_id = $video_id[1];
		
		$embed_link = 'http://www.youtube.com/embed/' . $video_id . '?rel=0';
		
		return $embed_link;
	}
	
	/**
	 * return array of subject level
	 */
	public static function getSubjectLevel()
	{
		return array('Primary'=>'Primary', 'Secondary'=>'Secondary', 'Tertiary'=>'Tertiary');
	}
	
	/**
	 * return array of faq categories
	 */
	public static function getFaqCategories()
	{
		return array('0'=>'General', '1'=>'Student', '2'=>'Tutor');
	}
	
	/**
	 * return an array of salutations 
	 * @return multitype:string
	 */
	public static function getSalutations()
	{
		return array('Mr'=>'Mr', 'Ms'=>'Ms', 'Mrs'=>'Mrs', 'Dr'=>'Dr', 'Prof'=>'Prof');
	}
	
	/**
	 * return array of states used in dropdownlist
	 * @param string $states
	 * @return array of states
	 */
	public static function getStates($states)
	{
		$states = explode(',', $states);
		
		$arr = array();
		
		foreach ($states as $state)
		{
			$arr[$state] = $state;
		}
		
		return $arr;
	}
	
	/**
	 * return an array of currencies
	 */
	public static function getCurrencies()
	{
		return array('AUD'=>"AUD", 'CAD'=>"CAD", 'CHF'=>"CHF", 'DKK'=>"DKK", 'EUR'=>'EUR', 'GBP'=>'GBP', 'HKD'=>'HKD', 'NOK'=>'NOK', 'NZD'=>'NZD', 'SEK'=>'SEK', 'SGD'=>'SGD', 'USD'=>'USD', );
	}
	
	/**
	 * 
	 * @param object $model
	 * @param file $stream
	 */
	public static function saveFile($model, $stream) 
	{
		//upload file
		$file = CUploadedFile::getInstance($model, $stream);

		if (!empty($file) && $file->getSize() > 0)
		{
			$path = md5($file->name) .'.'. $file->getExtensionName();
	
			$file->saveAs(self::getUserImageFolder($model->ref_account_id) . '/' . $path);
			
			return $path;
		}
		else
			return null;
	}
	
	/**
	 * return the path for user to save their photos
	 * @param int $user_id
	 */
	public static function getUserImageFolder($user_id)
	{
		if(!is_dir(app()->params['upload_gallery']))
		{
			mkdir(app()->params['upload_gallery']);
		}
		
		if(!is_dir(app()->params['upload_gallery'] . '/' . $user_id))
		{
			mkdir(app()->params['upload_gallery'] . '/' . $user_id);
		}
		
		return app()->params['upload_gallery'] . '/' . $user_id;
	}
	
	/**
	 * return all search km choices 
	 * @param array $array
	 */
	public static function getSearchKmChoices($array)
	{
		$array = explode(',', $array);
		
		$choices = array(''=>Common::translate('home', 'Postcode Only'));
		
		foreach ($array as $a)
		{
			$choices[$a] = Common::translate('search', 'Within') . ' ' . $a . 'km';
		}
		
		return $choices;
	}
	
	/**
	 * return all search review choices
	 * @param array $array
	 */
	public static function getSearchReviewChoices($array)
	{
		$array = explode(',', $array);
	
		$choices = array(''=>'');
	
		foreach ($array as $a)
		{
			$choices[$a] = $a . ' or more';
		}
	
		return $choices;
	}
	
	/**
	 * return all search feedback choices
	 */
	public static function getSearchFeedbackChoices($array)
	{
		$array = explode(',', $array);
	
		$choices = array(''=>'');
	
		foreach ($array as $a)
		{
			$choices[$a] = $a . ' ' . Common::translate('search', 'or more');
		}
	
		return $choices;
	}
	
	/**
	 *get lat and long of tutor address
	 * @param string $address
	 */
	public static function getLatLong($address)
	{
		$geocode	= file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false');
		$output		= json_decode($geocode);
		if(!empty($output->results))
		{
			$lat 				= $output->results[0]->geometry->location->lat;
			$long 				= $output->results[0]->geometry->location->lng;
	
			return array($lat, $long);
		}
		else
			return null;
	}
	
	/**
	 * Convert a string to a friendly string with SEO
	 */
	public static function toFriendlyStr($str)
	{
		$str = strtolower($str);
			
		static $replacements = array();
		if (empty($replacements)) {
			$patterns = "ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¡|a,ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â |a,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â£|a,ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â£|a,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â¡|a,ÃƒÆ’Ã¢â‚¬Å¾Ãƒâ€ Ã¢â‚¬â„¢|a,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â¯|a,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â±|a,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â³|a,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Âµ|a,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â·|a,ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢|a,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â¥|a,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â§|a,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â©|a,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â«|a,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â­|a,ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â©|e,ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¨|e,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â»|e,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â½|e,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â¹|e,ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Âª|e,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â¿|e,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»ÃƒÂ¯Ã‚Â¿Ã‚Â½|e,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€ Ã¢â‚¬â„¢|e,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â¦|e,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â¡|e,ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â­|i,ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¬|i,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â°|i,ÃƒÆ’Ã¢â‚¬Å¾Ãƒâ€šÃ‚Â©|i,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â¹|i,ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â³|o,ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â²|o,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»ÃƒÂ¯Ã‚Â¿Ã‚Â½|o,ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Âµ|o,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»ÃƒÂ¯Ã‚Â¿Ã‚Â½|o,ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â´|o,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»ÃƒÂ¢Ã¢â€šÂ¬Ã‹Å“|o,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»ÃƒÂ¢Ã¢â€šÂ¬Ã…â€œ|o,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â¢|o,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»ÃƒÂ¢Ã¢â€šÂ¬Ã¢â‚¬ï¿½|o,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»ÃƒÂ¢Ã¢â‚¬Å¾Ã‚Â¢|o,ÃƒÆ’Ã¢â‚¬Â Ãƒâ€šÃ‚Â¡|o,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»ÃƒÂ¢Ã¢â€šÂ¬Ã‚Âº|o,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»ÃƒÂ¯Ã‚Â¿Ã‚Â½|o,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€¦Ã‚Â¸|o,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Â¡|o,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Â£|o,ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Âº|u,ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¹|u,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Â§|u,ÃƒÆ’Ã¢â‚¬Â¦Ãƒâ€šÃ‚Â©|u,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Â¥|u,ÃƒÆ’Ã¢â‚¬Â Ãƒâ€šÃ‚Â°|u,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Â©|u,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Â«|u,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Â­|u,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Â¯|u,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Â±|u,ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â½|y,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Â³|y,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Â·|y,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Â¹|y,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Âµ|y,ÃƒÆ’Ã¢â‚¬Å¾ÃƒÂ¢Ã¢â€šÂ¬Ã‹Å“|d,ÃƒÆ’Ã†â€™ÃƒÂ¯Ã‚Â¿Ã‚Â½|A,ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬|A,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â¢|A,ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢|A,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â |A,ÃƒÆ’Ã¢â‚¬Å¾ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡|A,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â®|A,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â°|A,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â²|A,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â´|A,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â¶|A,ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡|A,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â¤|A,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â¦|A,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â¨|A,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Âª|A,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â¬|A,ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â°|E,ÃƒÆ’Ã†â€™Ãƒâ€¹Ã¢â‚¬Â |E,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Âº|E,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â¼|E,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â¸|E,ÃƒÆ’Ã†â€™Ãƒâ€¦Ã‚Â |E,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚ÂºÃƒâ€šÃ‚Â¾|E,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬|E,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡|E,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¾|E,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â |E,ÃƒÆ’Ã†â€™ÃƒÂ¯Ã‚Â¿Ã‚Â½|I,ÃƒÆ’Ã†â€™Ãƒâ€¦Ã¢â‚¬â„¢|I,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€¹Ã¢â‚¬Â |I,ÃƒÆ’Ã¢â‚¬Å¾Ãƒâ€šÃ‚Â¨|I,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€¦Ã‚Â |I,ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã…â€œ|O,ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢|O,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€¦Ã‚Â½|O,ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â¢|O,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€¦Ã¢â‚¬â„¢|O,ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã¯Â¿Â½|O,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»ÃƒÂ¯Ã‚Â¿Ã‚Â½|O,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»ÃƒÂ¢Ã¢â€šÂ¬Ã¢â€žÂ¢|O,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»ÃƒÂ¢Ã¢â€šÂ¬Ã¯Â¿Â½|O,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»ÃƒÂ¢Ã¢â€šÂ¬Ã¢â‚¬Å“|O,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€¹Ã…â€œ|O,ÃƒÆ’Ã¢â‚¬Â Ãƒâ€šÃ‚Â |O,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€¦Ã‚Â¡|O,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€¦Ã¢â‚¬Å“|O,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€¦Ã‚Â¾|O,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Â |O,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Â¢|O,ÃƒÆ’Ã†â€™Ãƒâ€¦Ã‚Â¡|U,ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â‚¬Å¾Ã‚Â¢|U,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Â¦|U,ÃƒÆ’Ã¢â‚¬Â¦Ãƒâ€šÃ‚Â¨|U,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Â¤|U,ÃƒÆ’Ã¢â‚¬Â Ãƒâ€šÃ‚Â¯|U,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Â¨|U,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Âª|U,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Â¬|U,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Â®|U,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Â°|U,ÃƒÆ’Ã†â€™ÃƒÂ¯Ã‚Â¿Ã‚Â½|Y,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Â²|Y,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Â¶|Y,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Â¸|Y,ÃƒÆ’Ã‚Â¡Ãƒâ€šÃ‚Â»Ãƒâ€šÃ‚Â´|Y,ÃƒÆ’Ã¢â‚¬Å¾ÃƒÂ¯Ã‚Â¿Ã‚Â½|D";
			$items = explode(",", $patterns);
			foreach ($items as $item) {
				@list($src, $dst) = explode("|", $item);
				$replacements[$src] = $dst;
			}
		}
		$str = strtr(trim($str), $replacements);
		//$str = strtolower(preg_replace(array('/\'/', '/[^a-zA-Z0-9]+/', '/(^_|_$)/'), array('', "-", ''), $str));
		$str = preg_replace(array('/\'/', '/[^a-zA-Z0-9]+/', '/(^_|_$)/'), array('', "-", ''), $str);
	
		return trim($str, "-");
	}
	
	/**
	 * return an array of all language
	 */
	public static function allLanguages()
	{
		$_countries = array(
				'Arabic'=>'Arabic',
				'Chinese - Cantonese'=>'Chinese - Cantonese',
				'Chinese - Mandarin'=>'Chinese - Mandarin',
				'English'=>'English',
				'Danish'=>'Danish',
				'Dutch'=>'Dutch',
				'Filipino'=>'Filipino',
				'Finish'=>'Finish',
				'French'=>'French',
				'German'=>'German',
				'Greek'=>'Greek',
				'Indonesian'=>'Indonesian',
				'Italian'=>'Italian',
				'Japanese'=>'Japanese',
				'Korean'=>'Korean',
				'Malay'=>'Malay',
				'Norwegian'=>'Norwegian',
				'Polish'=>'Polish',
				'Portuguese'=>'Portuguese',
				'Russian'=>'Russian',
				'Spanish'=>'Spanish',
				'Swedish'=>'Swedish',
				'Thai'=>'Thai',
				'Turkish'=>'Turkish',
				'Vietnamese'=>'Vietnamese',
				);
		return $_countries;
	}
	
	
}
