<?php

class SiteController extends Controller
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		//find random premium tutor
		$criteria = new CDbCriteria();
		
		$criteria->with = array('accounts');
		
		$criteria->condition = 'start_date < ? AND expire_date > ? AND accounts.role = ? AND accounts.status = ?';
		$criteria->params = array(time(), time(), Account::TUTOR, Account::ACTIVE);
		
		$criteria->order = 'rand()';
		
		$premium = TutorPremium::model()->find($criteria);
		
		//show random premium tutor
		$feature = '';
		
		if(empty($premium))
		{
			$criteria = new CDbCriteria();
			$criteria->condition = 'role = ? AND t.status = ?';
			$criteria->params = array(Account::TUTOR, Account::ACTIVE);
			$criteria->order = 'rand()';
			
			//show random tutor if there is no premium tutor
			$feature = Account::model()->find($criteria);
		}
		else
		{
			$feature = Account::model()->findByPk($premium->ref_account_id);
		}
		
		//data for lastest tutor section
		$criteria = new CDbCriteria;
		$criteria->condition = 'role = ? AND t.status = ?';
		$criteria->params = array(Account::TUTOR, Account::ACTIVE);
		$criteria->order = 'created DESC';
		$criteria->limit = $this->settings['count_latest_tutor'];
		$lastests = Account::model()->findAll($criteria);
		
		//data for random teacher section
		$criteria = new CDbCriteria();
		
		$criteria->join = 'INNER JOIN tutor_subjects as ts ON ts.ref_subject_id = t.id';
		
		$criteria->condition = 't.status = ? AND ts.status = ?';
		$criteria->params = array(Subject::ACTIVE, TutorSubject::ACTIVE);
		$criteria->order = 'rand()';
		//find a random subject
		$subject = Subject::model()->find($criteria);
		$teachers = null;
		
		if($subject)
		{
			//find teachers with random subject above
			$criteria = new CDbCriteria();
			$criteria = Profile::model()->browseTutorCriteria($subject->name);
			
			$teachers = Profile::model()->findAll($criteria);
		}
		
		//find block
		$page = Page::model()->find('slug = ?', array('home'));
		
		Common::insertMeta();
		
		$this->render('index', array(
				'feature'=>$feature,
				'lastests'=>$lastests,
				'subject'=>$subject,
				'teachers'=>$teachers,
				'page'=>$page,
				));
	}

	/**
	 * load teacher based on category
	 */
	public function actionLoadTeacher()
	{
		$subject = CPropertyValue::ensureString(request()->getParam('subject'));
		
		//find teachers with random subject above
		$criteria = new CDbCriteria();
		$criteria = Profile::model()->browseTutorCriteria($subject);
		
		$teachers = Profile::model()->findAll($criteria);
		
		$html = $this->renderPartial('_random_teacher', array('teachers'=>$teachers, 'subject'=>$subject), true);
		
		$subject_model = Subject::model()->find('name = ?', array($subject));
		
		echo json_encode(array('success'=>true, 'html'=>$html, 'subject_name'=>$subject_model->name));
	}
	
	/**
	 * feature suggestion page
	 */
	public function actionFeature()
	{
		$model = new ContactForm();
		
		//prefill name and email text box if user is login
		if(!app()->user->isGuest)
		{
			$account = Account::model()->findByPk(app()->user->id);
			
			$model->name = $account->first_name . ' ' . $account->last_name;
			$model->email = $account->email;
		}
		
		$contact_form = app()->request->getPost('ContactForm');
		
		if($contact_form)
		{
			$model->attributes = $_POST['ContactForm'];
				
			if($model->validate())
			{
				$this->sendMessage($model, 'Featured Suggestion');
				$this->refresh();
			}
		}
		
		//find block
		$page = Page::model()->find('slug = ?', array('feature-suggestion'));
		
		$this->pageTitle = $this->settings['site_title'] . ' :: Feature Suggestion';
		$this->change_title = true;
		
		Common::insertMeta();
		
		$this->render('feature_suggestion', array(
				'model'=>$model,
				'message'=>app()->user->getFlash('message'),
				'page'=>$page,
		));
	}
	
	/**
	 * contact page
	 */
	public function actionContact()
	{
		$model = new ContactForm();
		
		//prefill name and email text box if user is login
		if(!app()->user->isGuest)
		{
			$account = Account::model()->findByPk(app()->user->id);
				
			$model->name = $account->first_name . ' ' . $account->last_name;
			$model->email = $account->email;
		}
		
		$contact_form = app()->request->getPost('ContactForm');
		
		if($contact_form)
		{
			$model->attributes = $_POST['ContactForm'];
		
			if($model->validate())
			{
				$this->sendMessage($model, 'Contact');
				$this->refresh();
			}
		}
		
		//find block
		$page = Page::model()->find('slug = ?', array('contact'));
		
		$this->pageTitle = $this->settings['site_title'] . ' :: Contact';
		$this->change_title = true;
		
		Common::insertMeta();
		
		$this->render('contact', array(
				'model'=>$model,
				'message'=>app()->user->getFlash('message'),
				'page'=>$page,
		));
	}
	
	/**
	 * subjects available page
	 */
	public function actionSubjectAvailable()
	{
		$criteria = new CDbCriteria();
		$criteria->condition = 'status = ?';
		$criteria->params = array(Subject::ACTIVE);
		$criteria->order = 'root Asc, level Asc';
		
		$subjects = Subject::model()->findAll($criteria);
	
		//find block
		$page = Page::model()->find('slug = ?', array('subjects-available'));
		
		$this->pageTitle = $this->settings['site_title'] . ' :: Subjects Available';
		$this->change_title = true;
		
		Common::insertMeta();
		
		$this->render('subject_available', array(
				'subjects'=>$subjects,
				'page'=>$page,
		));
	}
	
	/**
	 * send message to admin when submit feature suggestion or contact form successfully
	 * @param model $model
	 * @param string $title
	 */
	public function sendMessage($model, $title)
	{
		//send message to admin
		$message = new Message();
		
		$message->sender_name = $model->name;
		$message->sender_email = $model->email;
		$message->title = $title;
		$message->content = $model->message;
		$message->created = date('Y-m-d H:i:s');
		
		$message->save();
		
		app()->user->setFlash('message', Common::translate('alert message', 'Your message has been sent to admin successfully'));
		
	}
	
	/**
	 * sitemap
	 */
	public function actionSitemap()
	{
		$criteria = new CDbCriteria();

		$criteria->select = 'suburb';
		$criteria->distinct = true;
		$criteria->order = 'suburb ASC';

		$suburbs = Profile::model()->findAll($criteria);

		$criteria = new CDbCriteria();
		$criteria->condition = 'status = ?';
		$criteria->params = array(Subject::ACTIVE);
		$criteria->order = 'root Asc, level Asc';
		
		$subjects = Subject::model()->findAll($criteria);
		
		$this->pageTitle = $this->settings['site_title'] . ' :: Sitemap';
		$this->change_title = true;
		
		Common::insertMeta();
		
		$this->render('sitemap', array(
				'suburbs'=>$suburbs,
				'subjects'=>$subjects,
		));
	}

	/**
	 * my shortlist page
	 */
	public function actionShortlist()
	{
		$tutor_shortlist_ids = isset(app()->request->cookies['tutor_shortlist_ids']) ? app()->request->cookies['tutor_shortlist_ids']->value : '';
		$tutor_shortlist_ids = !empty($tutor_shortlist_ids) ? $tutor_shortlist_ids : '0';

		$dataProvider = Profile::model()->searchShortlist($tutor_shortlist_ids);
		
		$this->pageTitle = $this->settings['site_title'] . ' :: Shortlist';
		$this->change_title = true;
		
		Common::insertMeta();
		
		$this->render('shortlist', array(
				'dataProvider'=>$dataProvider,
				));
	}
	
	/**
	 * faqs page
	 */
	public function actionFaq()
	{
		$criteria = new CDbCriteria();
		
		$criteria->condition = 'category = ? AND t.status = ?';
		$criteria->params = array(Faq::GENERAL, Faq::PUBLISHED);
		$criteria->order = 't.order ASC';
		
		$generals = Faq::model()->findAll($criteria);
		
		$criteria->params = array(Faq::STUDENT, Faq::PUBLISHED);
		
		$students = Faq::model()->findAll($criteria);
		
		$criteria->params = array(Faq::TUTOR, Faq::PUBLISHED);
		
		$tutors = Faq::model()->findAll($criteria);
		
		$this->render('faq', array(
				'generals'=>$generals,
				'students'=>$students,
				'tutors'=>$tutors,
		));
	}
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		$this->layout = '404';
		if($error=Yii::app()->errorHandler->error)
	    {
	    	//save error into database
	    	$model = new Error();
	    	$model->level = $error['type'] .':'. $error['code'];
	    	$model->title = $error['message'];
	    	$model->source = $error['file'] . ' on line ' . $error['line'];
	    	$model->content = $error['trace'];
	    	$model->created = date('Y-m-d H:i:s');
	    	
	    	$model->save();
	    	
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else {
	    		if(in_array($error['code'], array(404, 500)))
	    			$view = $error['code'];
	    		else
	    			$view = '404';
	    		
	    		$this->render($view);
	    	}
	    }
	    else 
	    {
	    	$this->render('404');
	    }
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect('/tutor/index');
		}
		
		$this->pageTitle = $this->settings['site_title'] . ' :: Login';
		$this->change_title = true;
		
		Common::insertMeta();
		
		// display the login form
		$this->render('login',array('model'=>$model, 'message'=>app()->user->getFlash('message')));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function actionForgotPassword()
	{
		$model = new ForgotPasswordForm();
		
		$forgot_password = app()->request->getPost('ForgotPasswordForm', false);
		
		if($forgot_password)
		{
			$model->attributes = $forgot_password;
			
			if($model->validate())
			{
				$account = Account::model()->find('email = ?', array($model->email));
				
				//insert hash
				$hash = new Hash();
				$hash->hash = md5(uniqid(). time());
				$hash->type = Account::TUTOR;
				$hash->id = $account->id;
				$hash->expire = strtotime('+6 hours');
				$hash->save();
				
				//send email
				$email = $account->email;
				$name = $account->first_name . ' ' . $account->last_name;
				$url = app()->request->hostInfo . '/site/resetPassword/token/' . $hash->hash;
				
				$params = array('name'=>$name, 'resetUrl'=>$url);
				
				list($content, $title) = MailHelper::parseTemplate('reset_password', $params);
				
				//save queue mail
				$queue = new Queue();
					
				$queue->sender_name = $this->settings['no_reply_name'];
				$queue->sender_email = $this->settings['no_reply_address'];
				$queue->recipient_name = $name;
				$queue->recipient_email = $email;
				$queue->title = $title;
				$queue->message = $content;
				$queue->status = Queue::SUCCESS;
				
				$queue->save();
				
				//sender's information
				$from = array('name'=>$queue->sender_name, 'email'=>$queue->sender_email);
				
				//recipient's information
				$to = array('name'=>$queue->recipient_name, 'email'=>$queue->recipient_email);
				
				$subject = $queue->title;
				$message = $queue->message;
				
				MailHelper::sendMail($from, $to, $subject, $message);
				
				app()->user->setFlash('message', Common::translate('alert message', 'Link to reset your password has been sent to your mail'));
				
				$this->refresh();
			}
		}
		
		//find block
		$page = Page::model()->find('slug = ?', array('forgot-password'));
		
		$this->pageTitle = $this->settings['site_title'] . ' :: Forgot Password';
		$this->change_title = true;
		
		Common::insertMeta();
		
		$this->render('forgot_password', array(
				'model'=>$model,
				'message'=>app()->user->getFlash('message'),
				'page'=>$page,
				));
	}
	
	public function actionResetPassword()
	{
		$hash = CPropertyValue::ensureString(request()->getParam('token'));
		
		$model = new ResetForm();
		
		//check whether hash is valid
		if (!empty($hash))
		{
			$time = time();
			$hash = Hash::model()->find('hash= ? AND expire > ?', array($hash, $time));
			
			if ($hash)
			{
				$account = Account::model()->findByPk($hash->id);
				
				//reset password
				$reset = app()->request->getPost('ResetForm', false);
				
				if($reset)
				{
					$model->attributes = $reset;
						
					if($model->validate())
					{
						$account->password = md5($model->newPassword);
						
						$account->save();
						
						//remove hash
						$hash->delete();
						
						app()->user->setFlash('message', Common::translate('alert message', 'Reset your password successfully'));
						
						$this->redirect(url('/site/login'));
					}
				}
				
			}
			else
			{
				app()->user->setFlash('message', Common::translate('alert message', 'This link has expired'));
			}
		}
		else
		{
			$message = app()->user->setFlash('message', Common::translate('alert message', 'Invalid Link'));
		}
		
		$this->pageTitle = $this->settings['site_title'] . ' :: Reset Password';
		$this->change_title = true;
		
		Common::insertMeta();
		
		$this->render('reset_password', array(
				'message'=>app()->user->getFlash('message'),
				'model'=>$model,
				));
	}
	
	/**
	 * resend activate account link for user
	 */
	public function actionResendActivate()
	{
		$email = CPropertyValue::ensureString(request()->getParam('email'));
		
		$model = new ResendActivateForm();
		$model->email = $email;
		
		$resend = app()->request->getPost('ResendActivateForm', false);
		
		if($resend)
		{
			$model->attributes = $resend;
			
			if($model->validate())
			{
				$account = Account::model()->find('LOWER(email)=?', array($email));
				
				if(!empty($account))
				{
					//insert hash
					$hash = new Hash();
					$hash->hash = md5(uniqid(). time());
					$hash->type = Account::TUTOR;
					$hash->id = $account->id;
					$hash->expire = strtotime('+30 days');
					$hash->save();
						
					//send email
					$email = $account->email;
					$name = $account->first_name . ' ' . $account->last_name;
					$url = app()->request->hostInfo . '/register/activate/token/' . $hash->hash;
						
					$params = array('name'=>$name, 'url'=>$url);
						
					list($content, $title) = MailHelper::parseTemplate('resend_activate_link', $params);
						
					//save queue mail
					$queue = new Queue();
				
					$queue->sender_name = $this->settings['no_reply_name'];
					$queue->sender_email = $this->settings['no_reply_address'];
					$queue->recipient_name = $name;
					$queue->recipient_email = $email;
					$queue->title = $title;
					$queue->message = $content;
					$queue->status = Queue::SUCCESS;
					
					$queue->save();
						
					//sender's information
					$from = array('name'=>$queue->sender_name, 'email'=>$queue->sender_email);
					
					//recipient's information
					$to = array('name'=>$queue->recipient_name, 'email'=>$queue->recipient_email);
					
					$subject = $queue->title;
					$message = $queue->message;
					
					MailHelper::sendMail($from, $to, $subject, $message);
					
					app()->user->setFlash('message', Common::translate('alert message', 'New activate link has been sent to your mail'));
						
					$this->redirect(url('/site/login'));
				}
				else
				{
					$this->redirect(url('/site/error'));
				}
			}
		}
		
		$this->pageTitle = $this->settings['site_title'] . ' :: Resend Activate';
		$this->change_title = true;
		
		Common::insertMeta();
		
		$this->render('resend_activate', array(
				'model'=>$model,
				));
		
	}
}