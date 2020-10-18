<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	
	public $status;
	
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$model = new Account();
        
        $username = strtolower($this->username);
        
//         $user = $model->find('LOWER(email)=? and status = 1 and role = ?',array($username, Account::TUTOR));
        $user = $model->find('LOWER(email)=? AND role = ?',array($username, Account::TUTOR));
        
		if( $user===null )
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if( $user->password != md5($this->password ))
		{
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		}
		else
		{
			if($user->status == Account::AWAITING)
			{
				$this->errorCode = self::ERROR_NONE;
				$this->status = Account::AWAITING;
			}
			elseif ($user->status == Account::INACTIVE)
			{
				$this->errorCode = self::ERROR_NONE;
				$this->status = Account::INACTIVE;
			}
			else
			{
				$this->_id = $user->id;
				$this->errorCode = self::ERROR_NONE;
				$this->status = Account::ACTIVE;
				$this->username = $user->email;
					
				//check enhanced's expired day
				if($user->is_enhance == Account::ENHANCE)
				{
					$expire_day = $user->enhance_expire;
				
					if(strtotime(date('Y-m-d H:i:s')) >= $expire_day)
					{
						$user->is_enhance = Account::BASIC;
						$user->enhance_start = 0;
						$user->enhance_expire = 0;
					}
				}
					
				//check premium's expired day
				if($user->is_premium == Account::PREMIUM)
				{
					$expire_day = $user->premium_expire;
						
					if(strtotime(date('Y-m-d H:i:s')) >= $expire_day)
					{
						$user->is_premium = Account::BASIC;
						$user->premium_start = 0;
						$user->premium_expire = 0;
					}
				}
				
				//save last login and previous login
				if(!empty($user->last_login))
				{
					$user->previous_login = $user->last_login;
					$user->last_login = date('Y-m-d H:i:s');
				}
				else 
				{
					$user->last_login = date('Y-m-d H:i:s');
				}
				
				$user->save();
			}
			
		}

		return !$this->errorCode;
	}
	
	public function adminLogin($id)
	{
		$this->_id = $id;
		
		//insert hash
		$hash = new Hash();
		$hash->hash = md5(uniqid(). time());
		$hash->type = 0;
		$hash->id = 0;
		$hash->expire = strtotime('+30 minutes');
		$hash->save();
		
		app()->user->setState('hash_admin', $hash->hash);
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