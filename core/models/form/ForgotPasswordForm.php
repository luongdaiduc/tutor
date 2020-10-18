<?php
class ForgotPasswordForm extends CFormModel
{
	public $email;
	
	
	public function rules()
	{
		return array(
			array('email', 'required'),
			array('email', 'validUserId'),
			array('email', 'email'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'email' => 'Email'
		);
	}
	
	public function validUserId($attribute,$params)
	{
		$valid = Account::model()->exists('LOWER(email)=:u AND status = :T AND role = :R', array(
			':u' => $this->email, ':T' => Account::ACTIVE, ':R' => Account::TUTOR,
		));
		if(!$valid)
			$this->addError('email','User not found. Please verify your input.');
	}
}