<?php
class Profile extends BaseProfile
{
	public $streamAvatar;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function rules()
	{
		$rules = array(
					array('suburb, gender, address, state, post_code, default_hourly_rate', 'required', 'message'=>'{attribute} ' . Common::translate('validation', 'cannot be blank')),
// 					array('suburb', 'required'),
					array('default_hourly_rate', 'numerical', 'integerOnly'=>true, 'message'=>'{attribute} ' . Common::translate('validation', 'must be an integer')),
					array('website', 'url', 'message'=>'{attribute} ' . Common::translate('validation', 'is not a valid URL')),
				);
	
		return CMap::mergeArray(parent::rules(), $rules);
	}
	
	public function relations()
	{
		$relations = array(
				'accounts' => array(self::BELONGS_TO, 'Account', 'ref_account_id'),
				'advertises' => array(self::HAS_ONE, 'Advertise', 'ref_account_id'),
				'states' => array(self::BELONGS_TO, 'State', 'state'),
		);
	
		return CMap::mergeArray(parent::relations(), $relations);
	}
	
	public function attributeLabels()
	{
		$labels = array(
				'suburb' => Common::translate('register', 'Suburb'),
				'address' => Common::translate('register', 'Address'),
				'post_code' => Common::translate('register', 'Postcode'),
				'default_hourly_rate' => Common::translate('register', 'Default Hourly Rate'),
				'website' => Common::translate('register', 'Website'),
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
	
	/**
	 * save lat long for tutor address
	 * @see CActiveRecord::afterSave()
	 */
	protected function afterSave()
	{
		//check whether profile is filled
		if(!empty($this->state))
		{
			$location = $this->address . ', ' .  $this->suburb . ' City' . ' ' . $this->states->state . ' ' . $this->post_code;
			$address = str_replace(' ', '+', strtolower($location));
			
			try {
				list($lat, $lng) = Common::getLatLong($address);
			
				Profile::model()->updateByPk($this->id, array('lat'=>$lat, 'lng'=>$lng));
			} catch (Exception $e) {
			
			}
		}
	}
	
	/**
	 * find all tutor in advance search page
	 * @param integer $subject
	 * @param string $level
	 * @param integer $min_experience
	 * @param integer $max_experience
	 * @param integer $premium_tutor
	 * @param integer $post_code
	 * @param integer $search_km
	 * @param string $state
	 * @param string $gender
	 * @param integer $min_rate
	 * @param integer $max_rate
	 * @param array $deliveries
	 * @param integer $min_star
	 * @param integer $max_star
	 * @param string suburb
	 * @return CActiveDataProvider
	 */
	public function advanceSearch($subject, $level, $min_experience, $max_experience, $post_code, $search_km, $gender, $min_rate, $max_rate, $deliveries, $min_star, $max_star, $suburb = null, $page = 0)
	{
		$criteria = new CDbCriteria();
		list($feature_account_id, $criteria, $normal_criteria, $premium_ids) = $this->getSearchCriteria($subject, $level, $min_experience, $max_experience, $post_code, $search_km, $gender, $min_rate, $max_rate, $deliveries, $min_star, $max_star, $suburb, $page);

		$dataProvider = new CActiveDataProvider($this, array('criteria'=>$criteria, 'pagination'=>array('pagesize'=>app()->controller->settings['count_search_result'])));
		
		return array($feature_account_id, $criteria, $normal_criteria, $premium_ids);
	}
	
	/**
	 * return search criteria
	 * @param integer $subject
	 * @param string $level
	 * @param integer $min_experience
	 * @param integer $max_experience
	 * @param integer $premium_tutor
	 * @param integer $post_code
	 * @param integer $search_km
	 * @param string $state
	 * @param string $gender
	 * @param integer $min_rate
	 * @param integer $max_rate
	 * @param array $deliveries 
	 * @param integer $min_star
	 * @param integer $max_star
	 * @return CActiveDataProvider
	 */
	public function getSearchCriteria($subject, $level, $min_experience, $max_experience, $post_code, $search_km, $gender, $min_rate, $max_rate, $deliveries, $min_star, $max_star, $suburb = null, $page = 0)
	{
		$feature_account_id = 0;
		$premium_ids = array();
		$account_ids = array();
		
		//check whether table tutor_subjects is joined or not
		$tutor_subject_join = false;
		
		$criteria = new CDbCriteria();
		
		$criteria->with = array('accounts');
		
		$criteria->distinct = true;

		$criteria->condition = 'accounts.status = ' . Account::ACTIVE . ' AND accounts.role = ' . Account::TUTOR;
		
		if(!empty($subject))
		{
			$criteria->join .= ' INNER JOIN tutor_subjects as ts ON ts.ref_account_id = t.ref_account_id';
			
			//condition for tutor subject table
			$criteria->condition .= ' AND ts.status = ' . TutorSubject::ACTIVE;
			
			$tutor_subject_join = true;
			
			$subject_model = Subject::model()->find('name = ?', array($subject));
			
			if(!empty($subject_model))
			{
				$feature_account_id = $subject_model->premiumAccountId();
					
				//find subject and child subjects
				$query = app()->db->createCommand()
				->select('id')
				->from(Subject::model()->tableName() .' s')
				->where('s.root like "'. $subject_model->root . '%" AND s.status = ' . Subject::ACTIVE)
				->queryAll();
					
				$subject_ids = array();
				foreach ($query as $q)
				{
					$subject_ids[] = $q['id'];
				}
					
				//show premium account on the top
				foreach ($subject_ids as $subject_id)
				{
					$s = Subject::model()->findByPk($subject_id);
				
					$premium_account_id = $s->premiumAccountId();
				
					if(!empty($premium_account_id))
					{
						if(!in_array($premium_account_id, $account_ids) && $premium_account_id != $feature_account_id)
						{
							$account_ids[] = $premium_account_id;
						}
							
					}
				}
					
				$criteria->condition .= ' AND ts.ref_subject_id IN(' . implode(',', $subject_ids) . ') AND ts.status = ' . TutorSubject::ACTIVE;
					
				//set default for slider
				$subjects = TutorSubject::model()->findAll('ref_subject_id = ?', array($subject_model->id));
					
				$tutor_account_ids = array();
				if(!empty($subjects))
				{
					foreach ($subjects as $subject)
					{
						$tutor_account_ids[] = $subject->ref_account_id;
					}
				}
					
				//set min/max value for slider
				Profile::model()->minMaxSlider($tutor_account_ids);
			}
			else 
			{
				$criteria->condition .= ' AND ts.ref_subject_id = 0';
				Profile::model()->minMaxSlider(array());
			}
		}
		else 
		{
			//set min/max value for slider
			Profile::model()->minMaxSlider(array());
		}
		
		if(!empty($level))
		{
			if(!$tutor_subject_join)
			{
				$criteria->join .= ' INNER JOIN tutor_subjects as ts ON ts.ref_account_id = t.ref_account_id';
				
				//condition for tutor subject table
				$criteria->condition .= ' AND ts.status = ' . TutorSubject::ACTIVE;
				
				$tutor_subject_join = true;
			}
			
			if($level != 'Any')
			{
				$criteria->condition .= ' AND ts.level = "' . $level . '"';
			}
		}
		
		if(!empty($max_experience))
		{
			if(!$tutor_subject_join)
			{
				$criteria->join .= ' INNER JOIN tutor_subjects as ts ON ts.ref_account_id = t.ref_account_id';
				
				//condition for tutor subject table
				$criteria->condition .= ' AND ts.status = ' . TutorSubject::ACTIVE;
				
				$tutor_subject_join = true;
			}
			
			$criteria->condition .= ' AND ts.experience >= ' . $min_experience . ' AND ts.experience <= ' . $max_experience;
		}
		
		if($post_code > 0)
		{
			//search tutor around post code
			if(!empty($search_km))
			{
				$state = State::model()->find('is_default = ?', array(State::IS_DEFAULT));
				
				//if there is no default state
				if(empty($state))
				{
					$state = State::model()->find();
				}
				
				$address = $state->state . ' ' . $post_code;
				
				$address = str_replace(' ', '+', strtolower($address));
				list($lat, $lng) = Common::getLatLong($address);

				$criteria->select = 't.*,(
									(
										(
											ACOS( SIN( (
												'. $lat .' * PI( ) /180 ) ) * SIN( (
													t.lat * PI( ) /180 )
												) + COS( (
													'. $lat .' * PI( ) /180 )
												) * COS( (
													t.lat * PI( ) /180 )
												) * COS( (
													( '. $lng .' - t.lng ) * PI( ) /180 )
												)
											)
										) *180 / PI( )
									) *60 * 1.1515 * 1.609344
								)  AS distance';
				
				$criteria->having = 'distance <= "' . $search_km . '"';
			}
			else 
			{
				$criteria->condition .= ' AND t.post_code = "' . $post_code . '"';
			}
			
		}
		
		if(!empty($gender))
		{
			if($gender != 'Any')
			{
				$criteria->condition .= ' AND t.gender = "' . $gender . '"';
			}
		}
		
		if(!empty($max_rate))
		{
			if(!$tutor_subject_join)
			{
				$criteria->join .= ' INNER JOIN tutor_subjects as ts ON ts.ref_account_id = t.ref_account_id';
			
				//condition for tutor subject table
				$criteria->condition .= ' AND ts.status = ' . TutorSubject::ACTIVE;
			
				$tutor_subject_join = true;
			}
			
			$criteria->condition .= ' AND ts.hourly_rate >= ' . $min_rate . ' AND ts.hourly_rate <= ' . $max_rate;
		}
		
		if(!empty($deliveries))
		{
			$criteria->join .= ' INNER JOIN tutor_deliveries as d ON d.ref_account_id = t.ref_account_id';
				
			$criteria->condition .= ' AND d.ref_delivery_id IN (' . implode(', ', $deliveries) . ')';
		}
		
		if(!empty($max_star))
		{
			$criteria->condition .= ' AND accounts.rating >= ' . $min_star . ' AND accounts.rating <= ' . $max_star;
		}
		
		if(!empty($suburb))
		{
			$criteria->condition .= ' AND suburb = "' . $suburb . '"';
		}
		
		//search all premium tutor if no subject was selected
		if(empty($subject))
		{
			$c = new CDbCriteria();
			
			$c->with = $criteria->with;
			$c->distinct = $criteria->distinct;
			$c->join = $criteria->join;
			$c->select = $criteria->select;
			$c->having = $criteria->having;
			$c->condition = $criteria->condition;
			$c->params = $criteria->params;
			
			$c->join .= ' INNER JOIN tutor_premiums as tp ON tp.ref_account_id = t.ref_account_id';
			$c->condition .= ' AND tp.start_date < ' . time() . ' AND tp.expire_date > ' . time();
			
			$c->order = 'rand()';
			
			$profile_premiums = Profile::model()->findAll($c);
			
			if(!empty($profile_premiums))
			{
				foreach ($profile_premiums as $idx => $profile_premium)
				{
					$premium_ids[] = $profile_premium->ref_account_id;
					
					if($idx == 0)
					{
						$feature_account_id = $profile_premium->ref_account_id;
					}
					else
					{
						$account_ids[] = $profile_premium->ref_account_id;
					}
				}
			}
		}
		
		$criteria->order = 'accounts.is_enhance DESC';
		
		//search all profile matched condition
		$profiles = Profile::model()->findAll($criteria);
		
		//normal account
		$normal_accounts_ids = array();
		
		if(!empty($profiles))
		{
			foreach ($profiles as $profile)
			{
				//update tutor profile search
				if($page == 0)
				{
					$profile->accounts->increaseTutorStatistic(TutorStatistic::PROFILE_SEARCH);
				}
				
				if(!in_array($profile->ref_account_id, $account_ids) && $profile->ref_account_id != $feature_account_id && $profile->accounts->is_enhance == Account::ENHANCE)
				{
					$account_ids[] = $profile->ref_account_id;
				}
				elseif (!in_array($profile->ref_account_id, $account_ids) && $profile->ref_account_id != $feature_account_id && $profile->accounts->is_enhance != Account::ENHANCE) 
				{
					$normal_accounts_ids[] = $profile->ref_account_id;
				}
			}
		}
		else 
		{
			//if no result found, show premium( if isset) only
			$account_ids = array(0);
		}
		
		//if no result( include premium) found
		if(empty($account_ids))
		{
			$account_ids = array(0);
		}
		
		//if no normal result found
		if(empty($normal_accounts_ids))
		{
			$normal_accounts_ids = array(0);
		}
		
		//return criteria for search paid tutor
		$criteria = new CDbCriteria();
		
		$select = 'CASE ';
		foreach ($account_ids as $index => $value) {
			$select .= ' WHEN t.ref_account_id = ' . $value . ' THEN ' . $index;
		}
		$select .= ' END AS order_id';
		
		$criteria->select = 't.*, ' . $select;
		$criteria->with = array('accounts');
		
		//order by premium, enhance account
		$criteria->order = 'order_id';
		
		$criteria->condition = 't.ref_account_id IN (' . implode(',', $account_ids) . ')';
		
		//return criteria for search normal tutor
		$normal_criteria = new CDbCriteria();
		
		$normal_criteria->with = array('accounts');
		$normal_criteria->condition = 't.ref_account_id IN (' . implode(',', $normal_accounts_ids) . ')';
		
		if(empty($feature_account_id))
		{
			$feature_account_id = 0;
		}
		
		return array($feature_account_id, $criteria, $normal_criteria, $premium_ids);
	}
	
	/**
	 * return min/max value for slider in search
	 * @param array $account_ids
	 */
	public function minMaxSlider($account_ids)
	{
		$query = '';
		
		//return min rate
		if(!empty($account_ids))
		{
			$query = app()->db->createCommand()
			->select('MIN(hourly_rate) AS minrate')
			->from(TutorSubject::model()->tableName())
			->where('ref_account_id IN (' . implode(',', $account_ids) . ') AND status = 1')
			->queryRow();
		}
		else 
		{
			$query = app()->db->createCommand()
			->select('MIN(hourly_rate) AS minrate')
			->from(TutorSubject::model()->tableName())
			->where('status = 1')
			->queryRow();
		}
		
		if(!empty($query))
		{
			app()->controller->selected['min_rate'] = $query['minrate'];
		}
		
		//return max rate
		if(!empty($account_ids))
		{
			$query = app()->db->createCommand()
			->select('MAX(hourly_rate) AS maxrate')
			->from(TutorSubject::model()->tableName())
			->where('ref_account_id IN (' . implode(',', $account_ids) . ') AND status = 1')
			->queryRow();
		}
		else 
		{
			$query = app()->db->createCommand()
			->select('MAX(hourly_rate) AS maxrate')
			->from(TutorSubject::model()->tableName())
			->where('status = 1')
			->queryRow();
		}
		
		if(!empty($query))
		{
			app()->controller->selected['max_rate'] = $query['maxrate'];
		}
		
		//return min experience
		if(!empty($account_ids))
		{
			$query = app()->db->createCommand()
			->select('MIN(experience) AS minexperience')
			->from(TutorSubject::model()->tableName())
			->where('ref_account_id IN (' . implode(',', $account_ids) . ') AND status = 1')
			->queryRow();
		}
		else 
		{
			$query = app()->db->createCommand()
			->select('MIN(experience) AS minexperience')
			->from(TutorSubject::model()->tableName())
			->where('status = 1')
			->queryRow();
		}
		if(!empty($query))
		{
			app()->controller->selected['min_experience'] = $query['minexperience'];
		}
		
		//return max experience
		if(!empty($account_ids))
		{
			$query = app()->db->createCommand()
			->select('MAX(experience) AS maxexperience')
			->from(TutorSubject::model()->tableName())
			->where('ref_account_id IN (' . implode(',', $account_ids) . ') AND status = 1')
			->queryRow();
		}
		else 
		{
			$query = app()->db->createCommand()
			->select('MAX(experience) AS maxexperience')
			->from(TutorSubject::model()->tableName())
			->where('status = 1')
			->queryRow();
		}
		if(!empty($query))
		{
			app()->controller->selected['max_experience'] = $query['maxexperience'];
		}
	}
	
	/**
	 * return tutor's subject's rate
	 * @param integer $ref_account_id
	 * @param integer $subject_name
	 */
	public function tutorSubjectRate($ref_account_id, $subject_name)
	{
		$criteria = new CDbCriteria();
		
		$criteria->with = array('subjects');
		$criteria->condition = 'ref_account_id = ? AND subjects.name = ?';
		$criteria->params = array($ref_account_id, $subject_name);
		
		$tutor_subject = TutorSubject::model()->find($criteria);
		
		if(!empty($tutor_subject))
		{
			return $tutor_subject->hourly_rate;
		}
		else 
		{
			//tutor don't have the subject that selected but have a child subject of selected subject
			return $this->default_hourly_rate;
		}
		
	}
	
	/**
	 * browse all tutors
	 * @param string $subject
	 * @param string $suburb
	 */
	public function browse($subject, $suburb)
	{
		$criteria = new CDbCriteria();
		
		//order by premium, enhance account
		$criteria->with = array('accounts');
		$criteria->order = 'accounts.is_enhance desc';
		
		$criteria->condition = 'accounts.status = ? AND accounts.role = ?';
		$criteria->params = array(Account::ACTIVE, Account::TUTOR);
		
		if(!empty($subject))
		{
			$criteria = $this->browseTutorCriteria($subject_id);
		}
		else
		{
			//set min/max value for slider
			Profile::model()->minMaxSlider(array());
		}
		
		//sitemap search
		if($suburb != '')
		{
			$criteria->condition .= ' AND suburb = ?';
			$criteria->params = CMap::mergeArray($criteria->params, array($suburb));;
		}

		return new CActiveDataProvider($this, array('criteria'=>$criteria, 'pagination'=>array('pagesize'=>app()->controller->settings['count_browse_tutor'])));
	}
	
	
	/**
	 * return criteria for search tutor based on subject id
	 * @param integer $subject_id
	 */
	public function browseTutorCriteria($subject)
	{
		$ids = array();
		
		$subject_model = Subject::model()->find('name = ?', array($subject));
		$premium_account_id = $subject_model->premiumAccountId();
		
		//show premium account on the top
		if(!empty($premium_account_id))
		{
			$ids[] = $premium_account_id;
		}
		
		//find subject and child subjects
		$query = app()->db->createCommand()
		->select('id')
		->from(Subject::model()->tableName() .' s')
		->where('s.root like "'. $subject_model->root . '%" AND s.status = ' . Subject::ACTIVE)
		->queryAll();
			
		$subject_ids = array();
		foreach ($query as $q)
		{
			$subject_ids[] = $q['id'];
		}

		//show premium account on the top
		foreach ($subject_ids as $subject_id)
		{
			$s = Subject::model()->findByPk($subject_id);
		
			$premium_account_id = $s->premiumAccountId();
		
			if(!empty($premium_account_id))
			{
				if(!in_array($premium_account_id, $ids))
				{
					$ids[] = $premium_account_id;
				}
					
			}
		}
		
		$criteria = new CDbCriteria();
		$criteria->with = array('accounts');
		$criteria->distinct = true;
		
		$criteria->condition = 'ref_subject_id IN(' . implode(',', $subject_ids) . ') AND t.status = ' . TutorSubject::ACTIVE;

		$criteria->order = 'accounts.is_enhance DESC';
		
		$tutor_subjects = TutorSubject::model()->findAll($criteria);
	
		if(!empty($tutor_subjects))
		{
			foreach ($tutor_subjects as $tutor_subject)
			{
				if(!in_array($tutor_subject->ref_account_id, $ids))
				{
					$ids[] = $tutor_subject->ref_account_id;
				}
				
			}
			
			//set min/max value for slider
			Profile::model()->minMaxSlider($ids);
		}
		else
		{
			$ids = array(0);
			
			//set min/max value for slider
			Profile::model()->minMaxSlider(array());
		}
	
		$criteria = new CDbCriteria();
		
		$select = 'CASE ';
		foreach ($ids as $index => $value) {
			$select .= ' WHEN t.ref_account_id = ' . $value . ' THEN ' . $index;
		}
		$select .= ' END AS order_id';
		
		$criteria->select = 't.*, ' . $select;
		
		$criteria->with = array('accounts');
		
		//order by premium, enhance account
		$criteria->order = 'order_id';
		$criteria->with = array('accounts');
		
		$criteria->condition = 'ref_account_id IN (' . implode(',', $ids) . ')';
		$criteria->condition .= ' AND accounts.status = ? AND accounts.role = ?';
		
		$criteria->order = 'order_id';
		
		$criteria->params = array(Account::ACTIVE, Account::TUTOR);
		
		return $criteria;
	}
	
	/**
	 * get tutor summary from tutor advertise based on tutor id
	 * @param integer $tutor_id
	 */
	public static function getTutorDetail($tutor_id)
	{
		$advertise = Advertise::model()->find('ref_account_id = ?', array($tutor_id));
	
		return $advertise->summary;
	}
	
	/**
	 * show tutor photo on search/browse if account type is enhance or premium
	 * @param integer $ref_account_id
	 */
	public function showTutorPhoto($ref_account_id)
	{
		$account = Account::model()->findByPk($ref_account_id);
		
		if($account->isFeature($account->id))
		{
			$avatar = Gallery::model()->getAvatar($ref_account_id);
			if(!empty($avatar))
				return CHtml::link(CHtml::image(app()->baseUrl . "/" . Common::getUserImageFolder($ref_account_id) . "/thumb-" . $avatar, "", array("width"=>"150")), Account::profileLink($ref_account_id));
			else
				return '';
		}
		else 
		{
			return '';
		}
	}
	
	/**
	 * my shortlist
	 * @param string $tutor_shortlist_ids
	 */
	public function searchShortlist($tutor_shortlist_ids)
	{
		$criteria = new CDbCriteria();
		
		$criteria->condition = 'id IN (' . $tutor_shortlist_ids . ')';
		
		return new CActiveDataProvider($this, array('criteria'=>$criteria));
	}
	
	/**
	 * show tutor rating star
	 * @param int $ref_account_id
	 */
	public function showRatingStar($ref_account_id)
	{
		$account = Account::model()->findByPk($ref_account_id);
		
		if(!empty($account))
		{
			if(!empty($account->rating) && number_format($account->rating) != 0)
			{
				$rating = ceil($account->rating);
					
				$active_star = $rating;
				$inactive_star = 5 - $rating;
					
				$star = '';
				for($i=1; $i<=$active_star; $i++) {
					$star .= '<div class="active_star"></div>';
				}
				for($i=1; $i<=$inactive_star; $i++) {
					$star .= '<div class="inactive_star"></div>';
				}
					
				return $star;
			}
			else 
			{
				return null;
			}
		}
		
	}
}