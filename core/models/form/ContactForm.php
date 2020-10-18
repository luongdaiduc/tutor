<?php
class ContactForm extends CFormModel
{
	public $name;
	public $email;
	public $message;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('name, email, message', 'required', 'message'=>'{attribute} ' . Common::translate('validation', 'cannot be blank')),
			array('email', 'email', 'message'=>Common::translate('validation', 'Email is not a valid email address')),
		);
	}
}