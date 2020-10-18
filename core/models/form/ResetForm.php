<?php
class ResetForm extends CFormModel
{
	public $newPassword;
	public $passwordRepeat;
		
	public function rules()
	{
		return array(
			array('newPassword, passwordRepeat', 'required'),
			array('newPassword', 'length', 'min' => 6),
			array('passwordRepeat', 'compare', 'compareAttribute' => 'newPassword'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'newPassword' => 'New Password',
			'passwordRepeat' => 'Re-type Password',
		);
	}
	
}