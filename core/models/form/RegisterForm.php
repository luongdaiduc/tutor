<?php
class RegisterForm extends CFormModel
{
	public $email;
	public $password;
	public $passwordRepeat;
	public $first_name;
	public $last_name;
		
	public function rules()
	{
		return array(
			array('first_name, last_name, email, password', 'required', 'message'=>'{attribute} ' . Common::translate('validation', 'cannot be blank')),
			array('password', 'length', 'min'=>'6', 'tooShort'=>Common::translate('validation', 'Password is too short (minimum is 6 characters)')),
			array('passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message'=>Common::translate('validation', "Passwords don't match")),
			array('email', 'unique', 'className'=>'Account', 'attributeName'=>'email', 'message'=>Common::translate('validation','Your email was already used by another user'), 'on'=>'create'),
			array('email', 'email', 'message'=>Common::translate('validation', 'Email is not a valid email address')),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'first_name' => Common::translate('register', 'First Name'),
			'last_name' => Common::translate('register', 'Last Name'),
			'email' => Common::translate('register', 'Email'),
			'password' => Common::translate('register', 'Password'),
		);
	}
	
}