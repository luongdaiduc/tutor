<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('password', 'required'),
			array('username', 'required', 'message'=>'Email cannot be blank'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			if(!$this->_identity->authenticate())
			{
				if($this->_identity->errorCode === UserIdentity::ERROR_PASSWORD_INVALID)
				{
					$this->addError('password','Incorrect password.');
				}
				if($this->_identity->errorCode === UserIdentity::ERROR_USERNAME_INVALID)
				{
					$this->addError('username','Email address is not registered.');
				}
			}
				
			if($this->_identity->status === Account::INACTIVE)
			{
				$this->addError('password','There is a problem logging in. Please contact us for assistance.');
			}
			if($this->_identity->status === Account::AWAITING)
			{
				$this->addError('password','Your account has not been activated. Please refer to the activation email to activate. Click <a href=' . url('/site/resendActivate', array('email'=>$this->username)) . '>here</a> to resend activation email');
			}
			
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE && $this->_identity->status == Account::ACTIVE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 3600*24; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
	
	/**
	 * Logs in facebook.
	 * @return boolean whether login is successful
	 */
	public function adminLogin($id)
	{
		$this->_identity=new UserIdentity($this->username,$this->password);
		
		$this->_identity->adminLogin($id);
		
		$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
		Yii::app()->user->login($this->_identity,$duration);
		
		return true;
	}
}
