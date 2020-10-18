<?php
class TutorController extends Controller
{
	public function filters()
	{
		return array(
				'accessControl',
		);
	}
	
	public function accessRules()
	{
		return array(
				array('deny',
						'actions'=>array('index', 'account', 'profile', 'advertise', 'tutorSubject', 'subject', 'manageMultiRecord', 'upgrade', 'invoice', 'createInvoice', 'premium', 'status', 'suggestSubject'),
						'users'=>array('?'),
				),
		);
	}
	
	/**
	 * tutor account homepage
	 */
	public function actionIndex()
	{
		$account = Account::model()->findByPk(app()->user->id);
		
		//find block
		$page = Page::model()->find('slug = ?', array('tutor-home'));
		
		$this->pageTitle = $this->settings['site_title'] . ' :: My Account';
		$this->change_title = true;
		
		$this->layout = 'account';
		$this->render('index', array(
				'page'=>$page,
				'account'=>$account,
				));
	}

	/**
	 * admin log in as a user
	 */
	public function actionAdminLogin()
	{
		$hash = CPropertyValue::ensureString(request()->getParam('hash'));
		
		if (!empty($hash))
		{
			$time = time();
			$hash = Hash::model()->find('hash= ? AND expire > ?', array($hash, $time));
			if ($hash)
			{
				$account_id = $hash->id;
				
				$account = Account::model()->findByPk($account_id);
				
				$login = new LoginForm();
				
				$login->username = $account->email;
				
				if($login->adminLogin($account_id))
				{
					$this->redirect('/tutor/account');
				}
			}
		}
	}

	/**
	 * edit login detail in tutor account management
	 */
	public function actionAccount()
	{
		$account = Account::model()->findByPk(app()->user->id);
		
		$model = new RegisterForm();
		$model->first_name = $account->first_name;
		$model->last_name = $account->last_name;
		$model->email = $account->email;
		$model->password = $account->password;
		$model->passwordRepeat = $account->password;
		
		if(isset($_POST['RegisterForm']))
		{
			$model->attributes = $_POST['RegisterForm'];
		
			if($model->email != $account->email)
			{
				$model->setScenario('create');
			}
			else
			{
				$model->setScenario('');
			}
			
			//validate and save edited account
			if($model->validate())
			{
				$account->email = $model->email;
				$account->first_name = $model->first_name;
				$account->last_name = $model->last_name;
				
				if($account->password != $model->password)
				{
					$account->password = md5($model->password);
				}
				
				$account->save();
				
				app()->user->setFlash('message', Common::translate('alert message', 'Change your login detail successfully'));
				
				$this->refresh();
				
			}
		}
		
		$this->pageTitle = $this->settings['site_title'] . ' :: My Account :: Login Detail';
		$this->change_title = true;
		
		$this->layout = 'account';
		$this->render('account', array(
				'model'=>$model,
				'message'=>app()->user->getFlash('message'),
				));
	}
	
	/**
	 * edit tutor profile in tutor account management
	 */
	public function actionProfile()
	{
		$model = Profile::model()->find('ref_account_id = ?', array(app()->user->id));
	
		if(isset($_POST['Profile']))
		{
			$model->attributes = $_POST['Profile'];
			$model->updated = date('Y-m-d H:i:s');
			
			//get gender for profile
// 			$model->gender = $_POST['gender'];
		
			if($model->save())
			{
				app()->user->setFlash('message', Common::translate('alert message', 'Change your contact detail successfully'));
					
				$this->refresh();
			}
		}
		
		$this->pageTitle = $this->settings['site_title'] . ' :: My Account :: Profile Detail';
		$this->change_title = true;
		
		$this->layout = 'account';
		$this->render('profile', array(
				'model'=>$model,
				'message'=>app()->user->getFlash('message'),
				));
		
	}
	
	/**
	 * edit tutor advertise
	 */
	public function actionAdvertise()
	{
		$model = Advertise::model()->find('ref_account_id = ?', array(app()->user->id));
		
		if(isset($_POST['Advertise']))
		{
			$model->attributes = $_POST['Advertise'];
			$model->updated = date('Y-m-d H:i:s');
			
			//get audience for advertise
			if(isset($_POST['audiences']))
			{
				$audiences = '';
				foreach ($_POST['audiences'] as $audience)
				{
					$audiences .= $audience . ', ';
				}
			
				$audiences = substr($audiences, 0, -2);
			
				$model->audiences = $audiences;
			}
	
			if($model->save())
			{
				//save deliveries for advertise
				if(isset($_POST['deliveries']))
				{
					TutorDelivery::model()->deleteAll('ref_account_id = ?', array(app()->user->id));
					
					foreach ($_POST['deliveries'] as $delivery)
					{
						$tutor_delivery = new TutorDelivery();
						$tutor_delivery->ref_account_id = app()->user->id;
						$tutor_delivery->ref_delivery_id = $delivery;
						$tutor_delivery->created = date('Y-m-d H:i:s');
						
						$tutor_delivery->save();
					}
				}
				
				app()->user->setFlash('message', Common::translate('alert message', 'Change your advertise detail successfully'));
					
				$this->refresh();
			}
		}
		
		//all tutor's deliveries
		$tutor_deliveries = TutorDelivery::model()->getTutorDeliveryIds();
		
		if(empty($tutor_deliveries))
		{
			$tutor_deliveries = array();
		}
		
		$this->pageTitle = $this->settings['site_title'] . ' :: My Account :: Advertise';
		$this->change_title = true;
		
		$this->layout = 'account';
		$this->render('advertise', array(
				'model'=>$model,
				'message'=>app()->user->getFlash('message'),
				'checked_deliveries'=>$tutor_deliveries,
				));
	}
	
	/**
	 * edit tutor subjects
	 */
	public function actionTutorSubject() 
	{
		$dataProvider = TutorSubject::model()->searchTutorSubject(app()->user->id);
		
		$this->pageTitle = $this->settings['site_title'] . ' :: My Account :: Subject';
		$this->change_title = true;
		
		$this->layout = 'account';
		$this->render('tutor_subject', array(
				'dataProvider'=>$dataProvider,
				'id'=>app()->user->id,
		));
	}
	
	/**
	 * add tutor subject
	 */
	public function actionSubject()
	{
		$account_id = app()->user->id;
		$id = CPropertyValue::ensureInteger(request()->getParam('id', 0));
	
		if($id == 0)
		{
			$model = new TutorSubject();
		}
		else
		{
			$model = TutorSubject::model()->findByPk($id);
		}
	
		$subject_form = app()->request->getPost('TutorSubject', false);
	
		if($subject_form)
		{
			$model->attributes = $subject_form;
			$model->ref_account_id = $account_id;
				
			if($model->save())
			{
				$this->redirect(url('/tutor/tutorSubject'));
			}
		}
	
		$subjects = Subject::listNestedSubject();
	
		$this->layout = 'account';
		$this->render('subject', array(
				'model'=>$model,
				'account_id'=>$account_id,
				'subjects'=>$subjects,
		));
	
	}
	
	/**
	 * delete, disable, enable selected subject
	 */
	public function actionManageMultiRecord()
	{
		$ids = CPropertyValue::ensureString(request()->getParam('ids'));
		$action = CPropertyValue::ensureString(request()->getParam('action'));
	
		$ids = explode(',', $ids);
	
		foreach ($ids as $id)
		{
			$tutor_subject = TutorSubject::model()->findByPk($id);
	
			if($action == 'delete')
			{
				$tutor_subject->delete();
			}
			elseif($action == 'disable')
			{
				$tutor_subject->status = TutorSubject::DISABLE;
				$tutor_subject->save();
			}
			elseif($action == 'enable')
			{
				$tutor_subject->status = TutorSubject::ACTIVE;
				$tutor_subject->save();
			}
		}
	
		echo json_encode(array('success'=>true));
	}
	
	/**
	 * get account id base on domain or basic domain or account id
	 * @param string $domain
	 * @param string $basic_domain
	 * @param integer $id
	 * @return account id
	 */
	public function getAccountId($domain, $basic_domain, $id)
	{
		//if tutor isn't a feature account
		if(!empty($domain))
		{
			$advertise = Advertise::model()->find('domain = ?', array($domain));
			
			if(!empty($advertise))
			{
				if($advertise->accounts->isFeature($advertise->ref_account_id) == 1)
				{
					$ref_account_id = $advertise->ref_account_id;
				}
				else 
				{
					return null;
				}
			}
			else 
			{
				return null;
			}
		}
		else
		{
			//if existed tutor's domain
			if(!empty($basic_domain))
			{
				$advertise = Advertise::model()->find('domain = ?', array($basic_domain));
					
				if(!empty($advertise))
				{
					$ref_account_id = $advertise->ref_account_id;
				}
				else 
				{
					return null;
				}
			}
			else 
			{
				$ref_account_id = $id;
			}
		}
		
		$account = Account::model()->find('id = ? and status = ?', array($ref_account_id, Account::ACTIVE));
		
		if(!empty($account))
		{
			return $ref_account_id;
		}
		else 
		{
			return null;
		}
	}
	
	/**
	 * tutor detail page
	 */
	public function actionDetail()
	{
		$domain = CPropertyValue::ensureString(request()->getParam('domain'));
		$basic_domain = CPropertyValue::ensureString(request()->getParam('basic_domain'));
		$id = CPropertyValue::ensureString(request()->getParam('id'));
		
		$ref_account_id = $this->getAccountId($domain, $basic_domain, $id);
			
		if(!empty($ref_account_id))
		{
			$account = Account::model()->findByPk($ref_account_id);
			$profile = Profile::model()->find('ref_account_id = ?', array($ref_account_id));
			$advertise = Advertise::model()->find('ref_account_id = ?', array($ref_account_id));
			
			$tutor_subjects = TutorSubject::model()->findAll('ref_account_id = ? and status = ?', array($ref_account_id, TutorSubject::ACTIVE));
			
			$array = array(
					'account'=>$account,
					'profile'=>$profile,
					'advertise'=>$advertise,
					'tutor_subjects'=>$tutor_subjects,
			);

			//register meta description
			cs()->registerMetaTag($advertise->summary, 'description');
			
			$keywords = $this->settings['site_title'] . ', ' . $advertise->title;
			
			//get tutor's subject from cache
			$subjects = TutorSubject::getTutorSubjectCache($account->id);
				
			if(!empty($subjects))
			{
				$keywords .= ', ' . implode(', ', $subjects);
			}
			
			//register meta keywords
			cs()->registerMetaTag($keywords, 'keywords');
			
			//update tutor's profile view
			$account->increaseTutorStatistic(TutorStatistic::PROFILE_VIEW);
			
			$this->pageTitle = $this->settings['site_title'] . ' :: ' . $account->first_name . ' ' . $account->last_name;
			$this->change_title = true;
			
			$this->render('detail', array(
					'account'=>$account,
					'view'=>'_view_profile',
					'array'=>$array,
			));
		}
		else
		{
			$this->redirect(url('/site/error'));
		}
	}
	
	/**
	 * show gallery in tutor detail page
	 */
	public function actionGallery()
	{
		$domain = CPropertyValue::ensureString(request()->getParam('domain'));
		$basic_domain = CPropertyValue::ensureString(request()->getParam('basic_domain'));
		$id = CPropertyValue::ensureString(request()->getParam('id'));
		
		$ref_account_id = $this->getAccountId($domain, $basic_domain, $id);
		
		if(!empty($ref_account_id))
		{
			$account = Account::model()->findByPk($ref_account_id);
			$advertise = $account->advertises;
			
			$photos = Gallery::model()->findAll('ref_account_id = ?', array($ref_account_id));
			
			$array = array('photos'=>$photos);
			
			//register meta description
			cs()->registerMetaTag($advertise->summary, 'description');
				
			$keywords = $this->settings['site_title'] . ', ' . $advertise->title;
				
			//get tutor's subject from cache
			$subjects = TutorSubject::getTutorSubjectCache($account->id);
			
			if(!empty($subjects))
			{
				$keywords .= ', ' . implode(', ', $subjects);
			}
				
			//register meta keywords
			cs()->registerMetaTag($keywords, 'keywords');
					
			$this->pageTitle = $this->settings['site_title'] . ' :: ' . $account->first_name . ' ' . $account->last_name . ' :: Gallery';
			$this->change_title = true;
			
			$this->render('detail', array(
					'account'=>$account,
					'view'=>'_view_gallery',
					'array'=>$array,
			));
		}
		else 
		{
			$this->redirect(url('/site/error'));
		}
	}
	
	/**
	 * contact page in tutor detail view
	 */
	public function actionContact()
	{
		$domain = CPropertyValue::ensureString(request()->getParam('domain'));
		$basic_domain = CPropertyValue::ensureString(request()->getParam('basic_domain'));
		$id = CPropertyValue::ensureString(request()->getParam('id'));
		
		$ref_account_id = $this->getAccountId($domain, $basic_domain, $id);
		
		if(!empty($ref_account_id))
		{
			$account = Account::model()->findByPk($ref_account_id);
			$advertise = $account->advertises;
			
			$model = new ContactForm();
			
			if(isset($_POST['ContactForm']))
			{
				$model->attributes = $_POST['ContactForm'];
			
				//send student contact to tutor email
				$email = $model->email;
				$student_name = $model->name;
				$message = $model->message;
			
				//tutor name
				$tutor_name = $account->first_name . ' ' . $account->last_name;
			
				$subject = 'Tutor - Student Contact';
			
				//save queue mail
				$queue = new Queue();
					
				$queue->sender_name = $student_name;
				$queue->sender_email = $email;
				$queue->recipient_name = $tutor_name;
				$queue->recipient_email = $account->email;
				$queue->title = $subject;
				$queue->message = $message;
					
				$queue->save();
					
				$this->refresh();
				
			}
			
			$array = array('model'=>$model, 'account'=>$account);
			
			//register meta description
			cs()->registerMetaTag($advertise->summary, 'description');
				
			$keywords = $this->settings['site_title'] . ', ' . $advertise->title;
				
			//get tutor's subject from cache
			$subjects = TutorSubject::getTutorSubjectCache($account->id);
			
			if(!empty($subjects))
			{
				$keywords .= ', ' . implode(', ', $subjects);
			}
				
			//register meta keywords
			cs()->registerMetaTag($keywords, 'keywords');
					
			$this->pageTitle = $this->settings['site_title'] . ' :: ' . $account->first_name . ' ' . $account->last_name . ' :: Contact';
			$this->change_title = true;
			
			$this->render('detail', array(
					'account'=>$account,
					'view'=>'_contact',
					'array'=>$array,
			));
		}
		else 
		{
			$this->redirect(url('/site/error'));
		}
		
	}
	
	/**
	 * review page in tutor detail page
	 */
	public function actionReview()
	{
		$domain = CPropertyValue::ensureString(request()->getParam('domain'));
		$basic_domain = CPropertyValue::ensureString(request()->getParam('basic_domain'));
		$id = CPropertyValue::ensureString(request()->getParam('id'));
		
		$ref_account_id = $this->getAccountId($domain, $basic_domain, $id);
		
		if(!empty($ref_account_id))
		{
			//return url for log in FB/GG/TT
			Yii::app()->user->returnUrl = Account::profileLink($ref_account_id, '/tutor/review', true);
			
			$account = Account::model()->findByPk($ref_account_id);
			$advertise = $account->advertises;
			
			//data from FB/GG/TT
			$data = '';
			
			//rate a tutor
			$rating_name = '';
			$rating_id = '';
			$rating_provider = '';
			
			if(!empty(app()->user->id))
			{
				$rator = Account::model()->findByPk(app()->user->id);
					
				$rating_name = $rator->first_name . ' ' . $rator->last_name;
				$rating_id = app()->user->id;
				$rating_provider = Review::SYSTEM;
			}
			else
			{
				$data = app()->user->getState('socialNetworkName');
				
				$rating_name = $data['name'];
				$rating_id = $data['login_provider_id'];
				$rating_provider = $data['provider'];
			}
			
			$is_rated = Review::model()->isRated($ref_account_id, $rating_id, $rating_provider);
			
			$model = new Review();
			
			$review = request()->getPost('Review', false);
			
			if($review)
			{
				$model->attributes = $review;
					
				if($model->validate())
				{
					$model->post_by = $rating_name;
					$model->ref_account_id = $ref_account_id;
					$model->login_provider_id = $rating_id;
					$model->provider = $rating_provider;
					
					$model->save(false);
			
					app()->user->setFlash('message', Common::translate('alert message', 'Rating successfully'));
			
					$this->refresh();
				}
					
			}
			
			$dataProvider = Review::model()->searchReview($ref_account_id);
			
			//register meta description
			cs()->registerMetaTag($advertise->summary, 'description');
				
			$keywords = $this->settings['site_title'] . ', ' . $advertise->title;
				
			//get tutor's subject from cache
			$subjects = TutorSubject::getTutorSubjectCache($account->id);
			
			if(!empty($subjects))
			{
				$keywords .= ', ' . implode(', ', $subjects);
			}
				
			//register meta keywords
			cs()->registerMetaTag($keywords, 'keywords');
				
			$this->pageTitle = $this->settings['site_title'] . ' :: ' . $account->first_name . ' ' . $account->last_name . ' :: Reviews';
			$this->change_title = true;
			
			$this->render('detail', array(
					'account'=>$account,
					'view'=>'_view_review',
					'array'=>array(
							'rating_name'=>$rating_name,
							'model'=>$model,
							'dataProvider'=>$dataProvider,
							'is_rated'=>$is_rated,
							'message'=>app()->user->getFlash('message'),
					),
			));
		}
		else 
		{
			$this->redirect(url('/site/error'));
		}
		
	}
	
	/**
	 * video page in tutor detai page
	 */
	public function actionVideo()
	{
		if($this->settings['video_enable'] == 1)
		{
			$domain = CPropertyValue::ensureString(request()->getParam('domain'));
			$basic_domain = CPropertyValue::ensureString(request()->getParam('basic_domain'));
			$id = CPropertyValue::ensureString(request()->getParam('id'));
			
			$ref_account_id = $this->getAccountId($domain, $basic_domain, $id);		
			
			if(!empty($ref_account_id))
			{
				$account = Account::model()->findByPk($ref_account_id);
				$advertise = $account->advertises;
					
				$dataProvider = Video::model()->searchVideo($ref_account_id);
					
				$array = array('dataProvider'=>$dataProvider);
				
				//register meta description
				cs()->registerMetaTag($advertise->summary, 'description');
					
				$keywords = $this->settings['site_title'] . ', ' . $advertise->title;
					
				//get tutor's subject from cache
				$subjects = TutorSubject::getTutorSubjectCache($account->id);
				
				if(!empty($subjects))
				{
					$keywords .= ', ' . implode(', ', $subjects);
				}
					
				//register meta keywords
				cs()->registerMetaTag($keywords, 'keywords');
						
				$this->pageTitle = $this->settings['site_title'] . ' :: ' . $account->first_name . ' ' . $account->last_name . ' :: Videos';
				$this->change_title = true;
				
				$this->render('detail', array(
						'account'=>$account,
						'view'=>'_video',
						'array'=>$array,
				));
			}
			else 
			{
				$this->redirect(url('/site/error'));
			}
			
		}
	}
	
	/**
	 * view tutor's video
	 */
	public function actionWatchVideo()
	{
		$id = CPropertyValue::ensureInteger(app()->request->getParam('id'));
		
		$video = Video::model()->findByPk($id);
		
		if(!empty($video))
		{
			//embed link
			$embed_link = Common::embedYoutube($video->video_url);
			
			$account = Account::model()->findByPk($video->ref_account_id);
			
			$this->render('watch_video', array(
					'video'=>$video,
					'account'=>$account,
					'embed_link'=>$embed_link,
			));
		}
		else
		{
			$this->redirect(url('/site/error'));
		}
	}
	
	/**
	 * tutor status, enhance or premium or basic
	 */
	public function actionStatus()
	{
		$account = Account::model()->findByPk(app()->user->id);
		
		if(!empty($account))
		{
			//find all tutor premium subject
			$tutor_premiums = TutorPremium::model()->findAll('ref_account_id = ?', array($account->id));
			
			$this->pageTitle = $this->settings['site_title'] . ' :: My Account :: Summary';
			$this->change_title = true;
			
			$this->layout = 'account';
			$this->render('status', array(
					'account'=>$account,
					'tutor_premiums'=>$tutor_premiums,
					));
		}
		else
		{
			$this->redirect(url('/site/error'));
		}
	}
	
	/**
	 * upgrade tutor account to enhance account or premium account
	 */
	public function actionUpgrade()
	{
		//find block for page's content
		$page = Page::model()->find('slug = ?', array('tutor-upgrade'));
		
		//find block for basic section
		$basic = Page::model()->find('slug = ?', array('basic-account'));
		
		//find block for enhance section
		$enhance = Page::model()->find('slug = ?', array('enhance-account'));
		
		//find block for premium section
		$premium = Page::model()->find('slug = ?', array('premium-account'));
		
		//get enhance paypal url
		$criteria = new CDbCriteria();
		
		$criteria->condition = 'type = ? and status = ?';
		$criteria->params = array(Subscription::ENHANCE, Subscription::PUBLISHED);
		
		$enhance_subscription = Subscription::model()->find($criteria);
		
		if(!empty($enhance_subscription))
		{
			$enhance_pay_url = Subscription::model()->getPaypalLink($enhance_subscription->id, app()->user->id, Subscription::ENHANCE);
		}
		
		$this->pageTitle = $this->settings['site_title'] . ' :: My Account :: Upgrade';
		$this->change_title = true;
		
		$this->layout = 'account';
		$this->render('upgrade', array(
				'page'=>$page,
				'basic'=>$basic,
				'enhance'=>$enhance,
				'premium'=>$premium,
				'enhance_pay_url'=>isset($enhance_pay_url) ? $enhance_pay_url : '',
				'message'=>app()->user->getFlash('message'),
				));
	}
	
	/**
	 * change paypal link when dropdownlist change, used in upgrade enhance account
	 */
	public function actionChangePaypalLink()
	{
		$subscription_id = CPropertyValue::ensureInteger(request()->getParam('subscription_id'));
		$type = CPropertyValue::ensureString(request()->getParam('type'));
		
		$model = Subscription::model()->findByPk($subscription_id);
		
		if($type == 'enhance')
		{
			$pay_url = Subscription::model()->getPaypalLink($subscription_id, app()->user->id, Subscription::ENHANCE);
		}
		
		$html = '<a href="' . $pay_url . '" class="btn btn-primary account_upgrade">Upgrade</a>';
		
		echo json_encode(array('success'=>true, 'html'=>$pay_url, 'type'=>$type));
	}
	
	/**
	 * action when user click return from paypal site
	 */
	public function actionPaypal()
	{
		// redirect and alert message
		if(empty($_POST)) 
		{
			//save error into database
			$model = new Error();
			$model->level = 'Paypal';
			$model->title = 'Cancel upgrade enhance account';
			$model->source = '/tutor/paypal';
			$model->content = 'User had canceled to upgrade account';
			$model->created = date('Y-m-d H:i:s');
			
			$model->save();
			
			app()->user->setFlash('message', Common::translate('alert message', 'You had canceled upgrade process. Upgrade your account failed'));
				
			$this->redirect(url('/tutor/upgrade'));
		}
		else 
		{
			app()->user->setFlash('message', Common::translate('alert message', 'Upgrade your account successfully'));
				
			$this->redirect(url('/tutor/upgrade'));
					
		}
	
	}
	
	/**
	 * upgrade enhance account, create transaction, invoice
	 */
	public function actionIpn()
	{
		$array = implode(" - ", $_POST);
		
		if(!empty($_POST))
		{
			//receive data from paypal ipn
			$account_id = $_POST['custom'];
				
			$subscription_id = $_POST['item_number'];
				
			$subscription = Subscription::model()->findByPk($subscription_id);
				
			$account_type = $subscription->type;
				
			$amount = $subscription->amount;
			$period = $subscription->period;
				
			//transaction id
			$txn = $_POST['txn_id'];
			
			$account = Account::model()->findByPk($account_id);
		
			//save tutor account type and its expire day
			if($account_type == Subscription::ENHANCE)
			{
				if($account->is_enhance == Account::ENHANCE)
				{
					$account->enhance_expire = strtotime('+ ' . $period, $account->enhance_expire);
				}
				else
				{
					$account->is_enhance = Account::ENHANCE;
					$account->enhance_start = strtotime(date('Y-m-d'));
					$account->enhance_expire = strtotime(date('Y-m-d H:i:s', strtotime('+ ' . $period)));
				}
			}
			else
			{
				if($account->is_premium == Account::PREMIUM)
				{
					$account->premium_expire = strtotime('+ ' . $period, $account->premium_expire);
				}
				else
				{
					$account->is_premium = Account::PREMIUM;
					$account->premium_start = strtotime(date('Y-m-d'));
					$account->premium_expire = strtotime(date('Y-m-d H:i:s', strtotime('+ ' . $period)));
				}
			}
		
			$account->save();
			
			//save transaction
			
			$transaction = new Transaction();
		
			$transaction->ref_account_id = $account_id;
			$transaction->txn_id = $txn;
			$transaction->payment_status = Transaction::COMPLETED;
			$transaction->payment_date = date('Y-m-d H:i:s');
			$transaction->mc_gross = $amount;
			$transaction->info = $account_type == Subscription::ENHANCE ? $period . ' enhanced listing on ' . app()->params['domain_name'] : $period . ' premium account on ' . app()->params['domain_name'];
			$transaction->status = 1;
		
			$transaction->save();

			//get expired day
			$expire_day = $account_type == Subscription::ENHANCE ? date('Y-m-d', $account->enhance_expire) : date('Y-m-d', $account->premium_expire);
		
			//save invoice
			$invoice = new Invoice();
			$invoice->ref_account_id = $account_id;
			$invoice->account_type = $account_type;
			$invoice->ref_transaction_id = $transaction->id;
			$invoice->expire_day = $expire_day;
			$invoice->amount = number_format($transaction->mc_gross);
			$invoice->currency = $subscription->currency;
			$invoice->save();
		
		}
	}
	
	/**
	 * upgrade premium account page
	 */
	public function actionPremium()
	{
		//find block for premium section
		$premium = Page::model()->find('slug = ?', array('upgrade-premium'));
	
		//data for dropdownlist
		$premiums = Subscription::model()->getPremium();
	
		//find all tutor's subject
		$criteria = new CDbCriteria();
		$criteria->condition = 'ref_account_id = ? AND t.status = ?';
		$criteria->params = array(app()->user->id, TutorSubject::ACTIVE);
	
		$tutor_subjects = TutorSubject::model()->findAll($criteria);
	
		//find all tutor's subject and parent subject
		$subjects = array();
		
		//prevent subject's duplication
		$exclude = array();
		
		if(!empty($tutor_subjects))
		{
			foreach ($tutor_subjects as $tutor_subject)
			{
				$criteria = new CDbCriteria();
				
				if(empty($exclude))
				{
					$criteria->condition = 'id = ? AND t.status = ?';
				}
				else
				{
					$criteria->condition = 'id = ? AND t.status = ? AND t.id NOT IN(' . implode(',', $exclude) . ')';
				}
				
				$criteria->params = array($tutor_subject->ref_subject_id, Subject::ACTIVE);
				
				$sub = Subject::model()->find($criteria);
	
				if(!empty($sub))
				{
					$root = explode('-', $sub->root);
					
					$level = $sub->level;
					$ref_parent_id = $sub->ref_parent_id;
					
					//add subject itself
					$subjects[] = $sub;
					$exclude[] = $sub->id;
					
					while ($level > 1)
					{
						$criteria = new CDbCriteria();
						$criteria->condition = 'id = ? AND t.status = ?';
						$criteria->params = array($ref_parent_id, Subject::ACTIVE);
						
						$parent = Subject::model()->find($criteria);
						
						if(!in_array($parent->id, $exclude))
						{
							//add subject's parent
							$subjects[] = $parent;
							$exclude[] = $parent->id;
						}
						
						$ref_parent_id = $parent->ref_parent_id;
						$level = $level - 1;
					}
				}
				
			}
		}
		
		$this->pageTitle = $this->settings['site_title'] . ' :: My Account :: Upgrade Gold Package';
		$this->change_title = true;
		
		$this->layout = 'account';
		$this->render('premium', array(
				'premium'=>$premium,
				'premiums'=>$premiums,
				'subjects'=>$subjects,
		));
	}
	
	/**
	 * change premium link when dropdownlist change, used in upgrade premium account
	 */
	public function actionChangePremiumLink()
	{
		$subscription_subject_ids = CPropertyValue::ensureString(request()->getParam('subscription_subject_ids'));
		$total = CPropertyValue::ensureString(request()->getParam('total'));
		
		$pay_url = '<a href="#" class="btn btn-primary">Upgrade</a>';
		
		if($subscription_subject_ids != '')
		{
			$pay_url = Subscription::model()->getPremiumLink($subscription_subject_ids, app()->user->id, $total);
		}
		
		echo json_encode(array('success'=>true, 'html'=>$pay_url));
	}
	
	/**
	 * action when user click return from paypal site
	 */
	public function actionPaypalPremium()
	{
		// redirect and alert message
		if(empty($_POST))
		{
			//save error into database
			$model = new Error();
			$model->level = 'Paypal';
			$model->title = 'Cancel upgrade premium account';
			$model->source = '/tutor/paypalPremium';
			$model->content = 'User had canceled to upgrade account';
			$model->created = date('Y-m-d H:i:s');
				
			$model->save();
				
			app()->user->setFlash('message', Common::translate('alert message', 'You had canceled upgrade process. Upgrade your account failed'));
	
			$this->redirect(url('/tutor/premium'));
		}
		else
		{
			app()->user->setFlash('message', Common::translate('alert message', 'Upgrade your account successfully'));
	
			$this->redirect(url('/tutor/premium'));
				
		}
	
	}
	
	/**
	 * upgrade premium account, create transaction, invoice
	 */
	public function actionIpnPremium()
	{
		if(!empty($_POST))
		{
			//receive data from paypal ipn
			$custom_data = $_POST['custom'];
			$custom_data = explode('+', $custom_data);
			
			$subscription_subject_ids = $custom_data[1];
			$subscription_subject_ids = explode(',', $subscription_subject_ids);
			
			$custom_data = explode('-', $custom_data[0]);
			
			$account_id = $custom_data[0];
			$amount = $custom_data[1];
			$quantity = $custom_data[2];
			
			//transaction id
			$txn = $_POST['txn_id'];
		
				//save tutor premium
				foreach ($subscription_subject_ids as $subscription_subject_id)
				{
					$subscription_subject_id = explode('-', $subscription_subject_id);
						
					$subscription_id = $subscription_subject_id[0];
						
					$subscription = Subscription::model()->findByPk($subscription_id);
						
					$period = $subscription->period;
				
					$subject_id = $subscription_subject_id[1];
					$subject = Subject::model()->findByPk($subject_id);
						
					$tutor_premium = TutorPremium::model()->find('ref_subject_id = ?', array($subject_id));
						
					if(empty($tutor_premium))
					{
						//if subject hasn't chosen by any tutor
						$new_tutor_premium = new TutorPremium();
				
						$new_tutor_premium->ref_account_id = $account_id;
						$new_tutor_premium->ref_subject_id = $subject_id;
						$new_tutor_premium->ref_subscription_id = $subscription_id;
						$new_tutor_premium->start_date = strtotime(date('Y-m-d H:i:s'));
						$new_tutor_premium->expire_date = strtotime(date('Y-m-d H:i:s', strtotime('+ ' . $period)));
				
						$new_tutor_premium->save();
				
						$subject->available_date = $new_tutor_premium->expire_date;
						$subject->save();
					}
					else
					{
						//if subject has chosen by another tutor
						$new_tutor_premium = new TutorPremium();
				
						$new_tutor_premium->ref_account_id = $account_id;
						$new_tutor_premium->ref_subject_id = $subject_id;
						$new_tutor_premium->ref_subscription_id = $subscription_id;
						if($subject->available_date > time())
						{
							$new_tutor_premium->start_date = $subject->available_date;
							$new_tutor_premium->expire_date = strtotime('+ ' . $period, $subject->available_date);
						}
						else
						{
							$new_tutor_premium->start_date = time();
							$new_tutor_premium->expire_date = strtotime('+ ' . $period, time());
						}
						
				
						$new_tutor_premium->save();
				
						$subject->available_date = $new_tutor_premium->expire_date;
						$subject->save();
					}
						
				}
					
				//save transaction
				$transaction = new Transaction();
				
				$transaction->ref_account_id = $account_id;
				$transaction->txn_id = $txn;
				$transaction->payment_status = Transaction::COMPLETED;
				$transaction->payment_date = date('Y-m-d H:i:s');
				$transaction->mc_gross = $amount;
				$transaction->info = 'Upgrade premium account';
				$transaction->status = 1;
					
				$transaction->save();
					
				//save invoice
				$invoice = new Invoice();
				$invoice->ref_account_id = $account_id;
				$invoice->account_type = Subscription::PREMIUM;
				$invoice->ref_transaction_id = $transaction->id;
				$invoice->subscription_subject_ids = implode(',', $subscription_subject_ids);
				$invoice->amount = number_format($transaction->mc_gross);
				$invoice->currency = $subscription->currency;
				$invoice->save();
			
		}
	}
	
	/**
	 * list all tutor invoices
	 */
	public function actionInvoice()
	{
		$criteria = new CDbCriteria();
		
		$criteria->condition = 'ref_account_id = ?';
		$criteria->params = array(app()->user->id);
		$criteria->order = 'created desc';
		
		$invoices = Invoice::model()->findAll($criteria);
		
		$this->pageTitle = $this->settings['site_title'] . ' :: My Account :: Invoices';
		$this->change_title = true;
		
		$this->layout = 'account';
		$this->render('invoice', array(
				'invoices'=>$invoices,
				));
	}
	
	/**
	 * output pdf file for tutor
	 */
	public function actionCreateInvoice()
	{
		$id = CPropertyValue::ensureInteger(request()->getParam('id'));
		
		$invoice = Invoice::model()->findByPk($id);
		
		if(empty($invoice) || (app()->user->id != $invoice->ref_account_id))
			$this->redirect(app()->params['siteUrl']);
		
		
		//get default settings
		$settings = $this->settings;
		
		//get default state
		$state_id = $settings['invoice_state'];
		$state = State::model()->findByPk($state_id);
		$default_state = $state->state;
		
		//create pdf file
		$mPDF1 = Yii::app()->ePdf->mpdf();

		$mPDF1->SetHTMLFooter('<div style="text-align:center;">' . $settings['invoice_footer'] . '</div>');
		
		//invoice for enhance 
		if(empty($invoice->subscription_subject_ids))
		{
			$mPDF1->WriteHTML(
					$this->renderPartial('_invoice', array(
							'transaction'=>$invoice->transactions,
							'account'=>$invoice->accounts,
							'expire_day'=>$invoice->expire_day,
							'settings'=>$settings,
							'default_state'=>$default_state,
							'invoice'=>$invoice,
					), true));
		}
		else 
		{
			$mPDF1->WriteHTML(
					$this->renderPartial('_invoice_premium', array(
							'transaction'=>$invoice->transactions,
							'account'=>$invoice->accounts,
							'expire_day'=>$invoice->expire_day,
							'settings'=>$settings,
							'default_state'=>$default_state,
							'invoice'=>$invoice,
					), true));
		}
		
		$mPDF1->Output($this->settings['site_title'] . ' - Invoice ' . $invoice->id . '.pdf', 'I');

	}
	
	/**
	 * hide or active account
	 */
	public function actionHide()
	{
		$account = Account::model()->findByPk(app()->user->id);
			
		if(!empty($account))
		{
			$hide = app()->request->getPost('hide', false);
			
			if($hide)
			{
				$status = $account->status == Account::HIDE ? Account::ACTIVE : Account::HIDE;
				
				$account->status = $status;
				
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
				
				//send email
				$email = $account->email;
				$name = $account->first_name . ' ' . $account->last_name;
				
				$params = array('name'=>$name, 'url'=>app()->params['siteUrl']);
				
				list($content, $title) = $status == Account::ACTIVE ? MailHelper::parseTemplate('active_advert', $params) : MailHelper::parseTemplate('hide_advert', $params);
				
				//save queue mail
				$queue = new Queue();
					
				$queue->sender_name = $this->settings['no_reply_name'];
				$queue->sender_email = $this->settings['no_reply_address'];
				$queue->recipient_name = $name;
				$queue->recipient_email = $email;
				$queue->title = $title;
				$queue->message = $content;
				
				$queue->save();
				
				app()->user->setFlash('message', $status == Account::ACTIVE ? Common::translate('alert message', 'You have successfully activated your advertisement') : Common::translate('alert message', 'You have successfully hidden your advertisement'));
				
				$this->refresh();
			}
			
			$this->pageTitle = $this->settings['site_title'] . ' :: My Account :: Hide Advertise';
			$this->change_title = true;
			
			$this->layout = 'account';
			$this->render('hide', array(
					'account'=>$account,
					'message'=>app()->user->getFlash('message'),
					));
		}
		
	}
	
	/**
	 * close account
	 */
	public function actionClose()
	{
		$hide = app()->request->getPost('hide', false);
			
		if($hide)
		{
			$account = Account::model()->findByPk(app()->user->id);
			
			if(!empty($account))
			{
				Advertise::model()->deleteAll('ref_account_id = ?', array($account->id));
				Profile::model()->deleteAll('ref_account_id = ?', array($account->id));
				TutorDelivery::model()->deleteAll('ref_account_id = ?', array($account->id));
				TutorSubject::model()->deleteAll('ref_account_id = ?', array($account->id));
				Gallery::model()->deleteAll('ref_account_id = ?', array($account->id));
				Invoice::model()->deleteAll('ref_account_id = ?', array($account->id));
				Transaction::model()->deleteAll('ref_account_id = ?', array($account->id));
				Video::model()->deleteAll('ref_account_id = ?', array($account->id));
				Review::model()->deleteAll('ref_account_id = ?', array($account->id));
				Hash::model()->deleteAll('id = ?', array($account->id));
				
				$account->delete();
				
				//send email
				$email = $account->email;
				$name = $account->first_name . ' ' . $account->last_name;
				
				$params = array('name'=>$name, 'url'=>app()->params['siteUrl']);
				
				list($content, $title) = MailHelper::parseTemplate('close_account', $params);
				
				//save queue mail
				$queue = new Queue();
					
				$queue->sender_name = $this->settings['no_reply_name'];
				$queue->sender_email = $this->settings['no_reply_address'];
				$queue->recipient_name = $name;
				$queue->recipient_email = $email;
				$queue->title = $title;
				$queue->message = $content;
				
				$queue->save();
			}
			
			$this->redirect(url('/site/logout'));
		}
		
		$this->pageTitle = $this->settings['site_title'] . ' :: My Account :: Close Account';
		$this->change_title = true;
		
		$this->layout = 'account';
		$this->render('close', array(
		));
	}
	
	public function actionSuggestSubject()
	{
		$account = Account::model()->findByPk(app()->user->id);
		$model = new SuggestSubjectForm();
		
		$suggest_subject = request()->getPost('SuggestSubjectForm', false);
		
		if($suggest_subject)
		{
			$model->attributes = $suggest_subject;
			
			if($model->validate())
			{
				//send message to admin
				$message = new Message();
				
				$message->sender_name = $account->first_name . ' ' . $account->last_name;
				$message->sender_email = $account->email;
				$message->title = 'Subject Suggestion';
				$message->content = 'I would like to suggest ' . $model->subject;
				$message->created = date('Y-m-d H:i:s');
				
				$message->save();
				
				app()->user->setFlash('message', Common::translate('alert message', 'Your message has been sent to admin successfully'));
				$this->refresh();
			}
		}
		
		$this->pageTitle = $this->settings['site_title'] . ' :: My Account :: Suggest Subject';
		$this->change_title = true;
		
		$this->layout = 'account';
		$this->render('suggest_subject', array(
				'model'=>$model,
				'message'=>app()->user->getFlash('message'),
				));
	}
}