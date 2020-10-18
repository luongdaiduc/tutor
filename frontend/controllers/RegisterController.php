<?php
class RegisterController extends Controller
{
	/**
	 * Register a new tutor
	 */
	public function actionAccount()
	{
		if(app()->user->isGuest)
		{
			$id = app()->user->getState('account_id');
			
			//create new register if session is empty
			if(empty($id))
			{
				$model = new RegisterForm();
				$model->setScenario('create');
			}
			else
			{
				$account = Account::model()->findByPk($id);
				
				$model = new RegisterForm();
				
				$model->setScenario('update');
				
				if(!empty($account))
				{
					$model->first_name = $account->first_name;
					$model->last_name = $account->last_name;
					$model->email = $account->email;
				}
				else 
				{
					//clear session
					app()->user->setState('account_id', null);
				}
			}
			
			$register_form = app()->request->getPost('RegisterForm', false);
			
			if($register_form)
			{
				$model->attributes = $register_form;
					
				//validate and redirect
				if($model->validate())
				{
					$exist_email = Account::model()->exists('email = ? and id <> ?', array($model->email, $id));
			
					if($exist_email)
					{
						$model->addError('email', 'Your email was already used by another user.');
					}
					else
					{	
						if(empty($id))
						{
							//create account
							$account = new Account();
								
							$account->first_name = $model->first_name;
							$account->last_name = $model->last_name;
							$account->email = $model->email;
							$account->password = md5($model->password);
							$account->role = Account::TUTOR;
							$account->status = Account::AWAITING;
							$account->save();
								
							//create profile
							$profile = new Profile();
							$profile->ref_account_id = $account->id;
							$profile->save(false);
								
							//create advertise
							$advertise = new Advertise();
							$advertise->ref_account_id = $account->id;
							$advertise->save(false);
								
							app()->user->setState('account_id', $account->id);
						}
						else
						{
							//create account
							$account = Account::model()->findByPk($id);
			
							if(!empty($account))
							{
								$account->first_name = $model->first_name;
								$account->last_name = $model->last_name;
								$account->email = $model->email;
								$account->password = md5($model->password);
								$account->save();
									
								app()->user->setState('register_info', $model);
								app()->user->setState('account_id', $account->id);
							}
							else
							{
								//clear session
								app()->user->setState('account_id', null);
							}
						}
						
						$this->redirect(url('/register/profile'));
					}
			
				}
			}
			
			$this->render('register_account', array(
					'model'=>$model,
			));
		}
		else
		{
			$this->redirect(url('/site/index'));
		}
	}
	
	/**
	 * register profile
	 */
	public function actionProfile()
	{
		if(app()->user->isGuest)
		{
			$id = app()->user->getState('account_id');
			
			if(!empty($id))
			{
				$profile = Profile::model()->find('ref_account_id = ?', array($id));
			
				$profile_form = app()->request->getPost('Profile', false);
					
				if($profile_form)
				{
					$profile->attributes = $profile_form;
						
					//get gender for profile
// 					$gender = app()->request->getPost('gender', false);
// 					$profile->gender = $gender;
						
					if($profile->validate())
					{
						$profile->save(false);
						
						$this->redirect(url('/register/advertise'));
					}
				}
					
				$this->render('register_profile', array(
						'profile'=>$profile,
						'id'=>$id,
				));
			}
			else
				$this->redirect(url('/register/account'));
		}
		else
		{
			$this->redirect(url('/site/index'));
		}
	}
	
	/**
	 * register advertise
	 */
	public function actionAdvertise()
	{
		if(app()->user->isGuest)
		{
			$id = app()->user->getState('account_id');
			
			if(!empty($id))
			{
				$advertise = Advertise::model()->find('ref_account_id = ?', array($id));
				$advertise->setScenario('create');
				
				$checked_deliveries = array();
					
				//set default domain
				$account = $advertise->accounts;
				$profile = Profile::model()->find('ref_account_id = ?', array($id));
				if(!empty($profile->company))
				{
					$advertise->domain = str_replace(' ', '', $profile->company);
				}
				else 
				{
					$advertise->domain = $account->first_name . '' . $account->last_name; 
				}
				$advertise->domain = strtolower($advertise->domain);
				
				$advertise->title = $profile->company;
				if(empty($advertise->title))
					$advertise->title = $account->first_name . ' ' . $account->last_name; 
				
				$advertise_form = app()->request->getPost('Advertise', false);
					
				if($advertise_form)
				{
					$advertise->attributes = $advertise_form;
						
					//get audience for advertise
					$audiences = app()->request->getPost('audiences');
					if($audiences)
					{
						$str = '';
						foreach ($audiences as $audience)
						{
							$str .= $audience . ', ';
						}
							
						$str = substr($str, 0, -2);
							
						if($str != '')
						{
							$advertise->audiences = $str;
						}
					}

					//get checked deliveries
					$deliveries = app()->request->getPost('deliveries', false);
						
					if($deliveries)
					{
						foreach ($deliveries as $delivery)
						{
							$checked_deliveries[] = $delivery;
						}
					}
					
					if($advertise->validate())
					{
						$advertise->save(false);

						//complete register
						app()->user->setState('complete_register', true);
						
						//save tutor deliveries
						if(!empty($deliveries))
						{
							//delete all old deliveries
							TutorDelivery::model()->deleteAll('ref_account_id = ?', array($id));
								
							foreach ($deliveries as $delivery)
							{
								$tutor_delivery = new TutorDelivery();
								$tutor_delivery->ref_account_id = $id;
								$tutor_delivery->ref_delivery_id = $delivery;
								$tutor_delivery->created = date('Y-m-d H:i:s');
									
								$tutor_delivery->save();
							}
						}
						
						$account = Account::model()->findByPk($id);
						
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
						
						$params = array('name'=>$name, 'activateUrl'=>$url);
						
						list($content, $title) = MailHelper::parseTemplate('sign_up', $params);
						
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
						
						$this->redirect(url('/register/tutorSubject'));
					}
				}
					
				$this->render('register_advertise', array(
						'advertise'=>$advertise,
						'checked_deliveries'=>$checked_deliveries,
						'id'=>$id,
				));
			}
			else
				$this->redirect(url('/register/account'));
		}
		else
		{
			$this->redirect(url('/site/index'));
		}
	}
	
	/**
	 * register subject and finish register tutor
	 */
	public function actionTutorSubject()
	{
		if(app()->user->isGuest)
		{
			$id = app()->user->getState('account_id');
			
			if(!empty($id))
			{
				//find all tutor subjects
				$dataProvider = TutorSubject::model()->searchTutorSubject($id);
					
				$this->render('tutor_subject', array(
						'dataProvider'=>$dataProvider,
						'id'=>$id,
				));
			}
			else
			{
				$this->redirect(url('/register/account'));
			}
		}
		else 
		{
			$this->redirect(url('/site/index'));
		}
	}
	
	/**
	 * add tutor subject
	 */
	public function actionSubject()
	{
		if(app()->user->isGuest)
		{
			$account_id = app()->user->getState('account_id');
			
			if(!empty($account_id))
			{
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
						$this->redirect(url('/register/tutorSubject'));
					}
				}
					
				$subjects = Subject::listNestedSubject();
					
				$this->render('subject', array(
						'model'=>$model,
						'account_id'=>$account_id,
						'subjects'=>$subjects,
				));
					
			}
			else
				$this->redirect(url('/register/account'));
		}
		else
		{
			$this->redirect(url('/site/index'));
		}
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
	 * activate account
	 */
	public function actionActivate()
	{
		$hash = CPropertyValue::ensureString(request()->getParam('token'));
		if (!empty($hash))
		{
			$time = time();
			$hash = Hash::model()->find('hash= ? AND expire > ?', array($hash, $time));
			if ($hash)
			{
				$account = Account::model()->findByPk($hash->id);
				
				if(!empty($account))
				{
					$account->status = Account::ACTIVE;
					$account->save(false);
					
					//remove hash
					$hash->delete();
					
					$message = 'Activating your account successfully.';
					
					$this->render('activate', array('message'=>$message));
				}
				else
				{
					$this->redirect(url('/site/error'));
				}
			} 
			else 
			{
				$this->redirect(url('/site/error'));
			}
		}
		else 
		{
			$this->redirect(url('/site/error'));
		}
	}
	
}