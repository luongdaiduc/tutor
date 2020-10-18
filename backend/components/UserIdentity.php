<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	public $status = 1;
	
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$model = new Account();
        
        $username = strtolower($this->username);
        
        $user = $model->find('LOWER(email)=? and status = 1 and role = ?',array($username, Account::ADMIN));
        
		if( $user===null )
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if( $user->password != md5($this->password ))
		{
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		}
		else
		{
			$this->_id = $user->id;
			$this->errorCode = self::ERROR_NONE;
			$this->username = $user->email;
		}

		return !$this->errorCode;
	}
	
	public function setId($value)
	{
		$this->_id = $value;
	}
	
	public function getId()
	{
		return $this->_id;
	}
}