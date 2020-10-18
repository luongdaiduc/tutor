<?php
class UserController extends Controller
{
	public function actionIndex()
	{
		$dataProvider = Account::model()->searchAllTutor();
		
		$this->render('index', array(
				'dataProvider'=>$dataProvider,
				));
	}
	
	/**
	 * create new account
	 */
	public function actionCreateAccount()
	{
		$model = new RegisterForm();
		$model->setScenario('create');

		$register_form = app()->request->getPost('RegisterForm', false);
		
		if($register_form)
		{
			$model->attributes = $register_form;
				
			//validate and redirect
			if($model->validate())
			{
				//create account
				$account = new Account();
					
				$account->first_name = $model->first_name;
				$account->last_name = $model->last_name;
				$account->email = $model->email;
				$account->password = md5($model->password);
				$account->role = Account::TUTOR;
				$account->save();
					
				//create profile
				$profile = new Profile();
				$profile->ref_account_id = $account->id;
				$profile->save(false);
					
				//create advertise
				$advertise = new Advertise();
				$advertise->ref_account_id = $account->id;
				$advertise->save(false);
						
				$this->redirect(url('/user/createProfile', array('id'=>$account->id)));

			}
		}
		
		$this->render('create_account', array(
				'model'=>$model,
		));
	}
	
	/**
	 * create profile
	 */
	public function actionCreateProfile()
	{
		$id = CPropertyValue::ensureInteger(request()->getParam('id'));
			
		if(!empty($id))
		{
			$profile = Profile::model()->find('ref_account_id = ?', array($id));
				
			$profile_form = app()->request->getPost('Profile', false);
				
			if($profile_form)
			{
				$profile->attributes = $profile_form;
					
				if($profile->validate())
				{
					$profile->save(false);
					
					$this->redirect(url('/user/createAdvertise', array('id'=>$id)));
				}
			}
			$this->render('create_profile', array(
					'profile'=>$profile,
					'id'=>$id,
			));
		}
		else 
		{
			$this->redirect(url('/user/createAccount'));
		}
	}
	
	public function actionCreateAdvertise()
	{
		$id = CPropertyValue::ensureInteger(request()->getParam('id'));
			
		if(!empty($id))
		{
			$advertise = Advertise::model()->find('ref_account_id = ?', array($id));
			$advertise->setScenario('create');
		
			//set default domain
			$profile = Profile::model()->find('ref_account_id = ?', array($id));
			if(!empty($profile->company))
			{
				$advertise->domain = str_replace(' ', '-', $profile->company);
			}
			else
			{
				$advertise->domain = $advertise->accounts->first_name . '-' . $advertise->accounts->last_name;
			}
		
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
		
				//save deliveries for advertise
				$deliveries = app()->request->getPost('deliveries');
		
				if($advertise->validate())
				{
					$advertise->save(false);
		
					//set active for account
					$account = Account::model()->findByPk($id);
					$account->status = Account::ACTIVE;
					$account->save();
					
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
		
					$this->redirect(url('/user'));
				}
			}
				
			$deliveries = Delivery::model()->allDeliveries();
			
			$this->render('create_advertise', array(
					'advertise'=>$advertise,
					'deliveries'=>$deliveries,
					'id'=>$id,
			));
		}
		else
			$this->redirect(url('/user/createAccount'));
	}
	
	/**
	 * edit user
	 */
	public function actionEdit()
	{
		$id = CPropertyValue::ensureInteger(request()->getParam('id', 0));

		$model = Account::model()->findByPk($id);

		// collect user input data
		$account = app()->request->getPost('Account', false);
	
		if($account)
		{
			$model->attributes = $account;
				
			if($model->save())
			{
				app()->user->setFlash('message', $id == 0 ? 'Add new user successfully' : 'Edit user successfully');
				$this->redirect(url('/user'));
			}
		}
	
		$this->render('edit', array(
				'model'=>$model,
		));
	}
	
	/**
	 * enable user log in as selected user
	 */
	public function actionLoginAsUser()
	{
		$id = CPropertyValue::ensureInteger(request()->getParam('id'));
		
		$account = Account::model()->findByPk($id);
		//insert hash
		$hash = new Hash();
		$hash->hash = md5(uniqid(). time());
		$hash->type = Account::TUTOR;
		$hash->id = $account->id;
		$hash->expire = strtotime('+30 days');
		$hash->save();
		
		$this->redirect(app()->params['siteUrl'] . url('/tutor/adminLogin', array('hash'=>$hash->hash)));
	}
	
	/**
	 * delete user
	 */
	public function actionManageRecord()
	{
		$ids = CPropertyValue::ensureString(request()->getParam('ids'));
		$action = CPropertyValue::ensureString(request()->getParam('action'));
	
		$ids = explode(',', $ids);
	
		foreach ($ids as $id)
		{
			$user = Account::model()->findByPk($id);
			
			if($action == 'delete')
			{
				Advertise::model()->deleteAll('ref_account_id = ?', array($user->id));
				Profile::model()->deleteAll('ref_account_id = ?', array($user->id));
				TutorDelivery::model()->deleteAll('ref_account_id = ?', array($user->id));
				TutorSubject::model()->deleteAll('ref_account_id = ?', array($user->id));
				Gallery::model()->deleteAll('ref_account_id = ?', array($user->id));
				Invoice::model()->deleteAll('ref_account_id = ?', array($user->id));
				Transaction::model()->deleteAll('ref_account_id = ?', array($user->id));
				Video::model()->deleteAll('ref_account_id = ?', array($user->id));
				Review::model()->deleteAll('ref_account_id = ?', array($user->id));
				Hash::model()->deleteAll('id = ?', array($user->id));
				
				$user->delete();
				
				
			}
			elseif($action == 'disable')
			{
				$user->status = Account::INACTIVE;
				$user->save();
				
// 				echo json_encode(array('success'=>true));
			}
			elseif($action == 'enable')
			{
				$user->status = Account::ACTIVE;
				$user->save();
			
// 				echo json_encode(array('success'=>true));
			}
			else
			{
// 				echo json_encode(array('redirect'=>true, 'url'=>url('/user/loginAsUser', array('id'=>$id))));
			}
		}
	 
		echo json_encode(array('success'=>true));
	}
}