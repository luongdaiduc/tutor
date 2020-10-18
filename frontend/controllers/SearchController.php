<?php
class SearchController extends Controller
{
	public $defaultAction = 'index';
	
	public function actionIndex()
	{	
		$subjects = TutorSubject::model()->findAll();
		
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
		
		$this->pageTitle = $this->settings['site_title'] . ' :: ' . 'Search Tutors';
		$this->change_title = true;
		
		Common::insertMeta();
		
		$this->render('index');
	}
	
	/**
	 * search tutor based on input
	 */
	public function actionResult()
	{
		$subject = CPropertyValue::ensureString(request()->getQuery('subject'));
		
		$min_experience = CPropertyValue::ensureInteger(request()->getParam('min_experience', 0));
		$max_experience = CPropertyValue::ensureInteger(request()->getParam('max_experience', 0));
		$level = CPropertyValue::ensureString(request()->getParam('level'));
	
		$post_code = CPropertyValue::ensureInteger(request()->getParam('post_code', 0));
		$search_km = CPropertyValue::ensureString(request()->getParam('search_km'));
		
		$deliveries = CPropertyValue::ensureArray(request()->getParam('deliveries'));
		$gender = CPropertyValue::ensureString(request()->getParam('gender'));
		$min_rate = CPropertyValue::ensureInteger(request()->getParam('min_rate', 0));
		$max_rate = CPropertyValue::ensureInteger(request()->getParam('max_rate', 0));
		
		$min_star = CPropertyValue::ensureInteger(request()->getParam('min_star', 0));
		$max_star = CPropertyValue::ensureInteger(request()->getParam('max_star', 0));

		$suburb = CPropertyValue::ensureString(request()->getParam('suburb'));
		
		$dataProvider = '';

		$page = Yii::app()->request->getParam('page', 0);
		
		list($feature_account_id, $criteria, $normal_criteria, $premium_ids) = Profile::model()->advanceSearch($subject, $level, $min_experience, $max_experience, $post_code, $search_km, $gender, $min_rate, $max_rate, $deliveries, $min_star, $max_star, $suburb, $page);
		
		$feature_account = Account::model()->findByPk($feature_account_id);
		
		//paid tutor section
		$paid_accounts = Profile::model()->findAll($criteria);
		
		//normal tutor section
		$total = Profile::model()->count($normal_criteria);
		
		$page_size = $this->settings['count_search_result'];
		$init_page = 5;
		$total = $total - $init_page + $page_size;
		
		$page = $page == 0 ? 1 : $page;
		
		if($page == 1) {
			$limit = $page == 1 ? $init_page : $page_size;
			$offset = 0;
		}
		else {
			$limit = $page_size;
			$offset = $init_page + ($page - 2)* $page_size;
		}
		
		$normal_criteria->limit = $limit;
		$normal_criteria->offset = $offset;
		
		$models = Profile::model()->findAll($normal_criteria);
		
		//set selected item
		$this->selected['subject'] = $subject;
		$this->selected['postcode'] = $post_code > 0 ? $post_code : '';
		$this->selected['km'] = $search_km;
		$this->selected['level'] = $level;
		$this->selected['gender'] = $gender;
		$this->selected['deliveries'] = $deliveries;
		$this->selected['selected_min_rate'] = $min_rate > 0 ? $min_rate : $this->selected['min_rate'];
		$this->selected['selected_max_rate'] = $max_rate > 0 ? $max_rate : $this->selected['max_rate'];
		$this->selected['selected_min_experience'] = $min_experience > 0 ? $min_experience : $this->selected['min_experience'];
		$this->selected['selected_max_experience'] = $max_experience > 0 ? $max_experience : $this->selected['max_experience'];
		
		$this->pageTitle = $this->settings['site_title'] . ' :: ' . 'Search Results';
		$this->change_title = true;
		
		Common::insertMeta();
		
		$this->layout = 'search';
		$this->render('result', array(
				'subject'=>$subject,
				'dataProvider'=>$dataProvider,
				'feature_account'=>$feature_account,
				'paid_accounts'=>$paid_accounts,
				'premium_ids'=>implode(',', $premium_ids),
				'total'=>$total,
				'models'=>$models,
				'page'=>$page,
				'page_size'=>$page_size,
				'init_page'=>$init_page,
		));
		
	}
	
	/**
	 * render slider 
	 */
	public function actionValueSlider()
	{
		$subject = CPropertyValue::ensureString(request()->getParam('subject'));
	
		$criteria = new CDbCriteria();
		$criteria->with = array('subjects');
		$criteria->condition = 'subjects.name = ?';
		$criteria->params = array($subject);
		
		$subjects = TutorSubject::model()->findAll($criteria);
		
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
		
		echo json_encode(array('success'=>true, 'min_rate'=>$this->selected['min_rate'], 'max_rate'=>$this->selected['max_rate'], 'min_experience'=>$this->selected['min_experience'], 'max_experience'=>$this->selected['max_experience']));
	}
	
	/**
	 * render random premium tutor at the top of search result
	 */
	public function actionPremium()
	{
// 		ids of result show on gridview
		$ids = CPropertyValue::ensureString(request()->getParam('ids'));
		
		//premium ids of search result
		$premium_ids = CPropertyValue::ensureString(request()->getParam('premium_ids'));
		
		$criteria = new CDbCriteria();
		
		$criteria->with = array('profiles');
		
		$criteria->condition = 't.id IN(' . $premium_ids . ') AND profiles.id NOT IN(' . $ids . ')';
		
		$criteria->order = 'rand()';
		
		$account = Account::model()->find($criteria);
		
		$html = $this->renderPartial('/site/_feature', array('feature'=>$account), true);
		
		echo json_encode(array('success'=>true, 'html'=>$html));
	}
	
	/**
	 * google map show tutor
	 */
	public function actionMap()
	{
		if(app()->request->isAjaxRequest)
		{
			$subject = CPropertyValue::ensureString(request()->getParam('subject'));
			
			$min_experience = CPropertyValue::ensureInteger(request()->getParam('min_experience', 0));
			$max_experience = CPropertyValue::ensureInteger(request()->getParam('max_experience', 0));
			$level = CPropertyValue::ensureString(request()->getParam('level'));
			
			$post_code = CPropertyValue::ensureInteger(request()->getParam('post_code', 0));
			$search_km = CPropertyValue::ensureString(request()->getParam('search_km'));
			
			$deliveries = CPropertyValue::ensureArray(request()->getParam('deliveries'));
			$gender = CPropertyValue::ensureString(request()->getParam('gender'));
			$min_rate = CPropertyValue::ensureInteger(request()->getParam('min_rate', 0));
			$max_rate = CPropertyValue::ensureInteger(request()->getParam('max_rate', 0));

			//data for google map
			$titles = array();
			$latlngs = array();
			$summaries = array();
			
			$criteria = new CDbCriteria();
			
			list($feature_account_id, $criteria, $normal_criteria, $premium_ids) = Profile::model()->getSearchCriteria($subject, $level, $min_experience, $max_experience, $post_code, $search_km, $gender, $min_rate, $max_rate, $deliveries, null, null);
			
			$criteria->condition .= ' OR t.ref_account_id = ' . $feature_account_id;
			
			//paid tutor
			$profiles = Profile::model()->findAll($criteria);

			if(!empty($profiles))
			{
				foreach ($profiles as $profile)
				{
					$latlngs[] = array($profile->lat, $profile->lng);

					//data use for google map info window
					$titles[] = array('name'=> htmlspecialchars($profile->accounts->first_name . ' ' . $profile->accounts->last_name), 'url'=>Account::profileLink($profile->ref_account_id),'id'=>$profile->id);
					$advertise = Advertise::model()->find('ref_account_id = ? ', array($profile->ref_account_id));
					$summaries[] = $advertise->summary;
				}

			}
			
			//normal tutor
			$normal_profiles = Profile::model()->findAll($normal_criteria);
			
			if(!empty($normal_profiles))
			{
				foreach ($normal_profiles as $profile)
				{
					$latlngs[] = array($profile->lat, $profile->lng);
			
					//data use for google map info window
					$titles[] = array('name'=> htmlspecialchars($profile->accounts->first_name . ' ' . $profile->accounts->last_name), 'url'=>Account::profileLink($profile->ref_account_id),'id'=>$profile->id);
					$advertise = Advertise::model()->find('ref_account_id = ? ', array($profile->ref_account_id));
					$summaries[] = $advertise->summary;
				}
			
			}
			
			if(!empty($profiles) || !empty($normal_profiles))
			{
				echo json_encode(array('success'=>true, 'titles' => $titles, 'latlngs' => $latlngs, 'summaries' => $summaries));
			}
			else
			{
				//set min/max value for slider
				Profile::model()->minMaxSlider(array());
				
				echo json_encode(array('success'=>false));
			}

		}
		else
		{
			//find all enhanced and premium tutor
			$criteria = new CDbCriteria();

			$criteria->distinct = true;
			$criteria->with = array('accounts');
				
			$criteria->join = ' INNER JOIN tutor_premiums as tp ON tp.ref_account_id = t.ref_account_id';
			$criteria->condition = '(tp.start_date < ' . time() . ' AND tp.expire_date > ' . time() . ') OR (accounts.is_enhance = ' . Account::ENHANCE . ') AND accounts.role = ' . Account::TUTOR . ' AND accounts.status = ' . Account::ACTIVE;
				
			$profiles = Profile::model()->findAll($criteria);
			
			//data for google map
			$titles = array();
			$latlngs = array();
			$summaries = array();
			
			if(!empty($profiles))
			{
// 				$account_ids = array();
				foreach($profiles as $profile)
				{
// 					$account_ids[] = $account->id;
					
// 					$profile = $account->profiles;
						
					$latlngs[] = array($profile->lat, $profile->lng);
						
					//data use for google map info window
					$titles[] = array('name'=> htmlspecialchars($profile->accounts->first_name . ' ' . $profile->accounts->last_name), 'url'=>Account::profileLink($profile->ref_account_id),'id'=>$profile->id);
					$advertise = $profile->accounts->advertises;
					$summaries[] = $advertise->summary;
				}
				
			}
			
			//set min/max value for slider
			Profile::model()->minMaxSlider(array());
			
			$this->pageTitle = $this->settings['site_title'] . ' :: ' . 'Map';
			$this->change_title = true;
			
			Common::insertMeta();
			
			$this->layout = 'search';
			$this->render('map', array(
					'titles' => json_encode($titles),
					'latlngs' => CJavaScript::jsonEncode($latlngs),
					'summaries' => json_encode($summaries),
			));
		}
	}
	
}