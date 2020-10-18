<?php
class SuggestSubjectForm extends CFormModel
{
	public $subject;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('subject', 'required', 'message'=>'{attribute} ' . Common::translate('validation', 'cannot be blank')),
			array('subject', 'unique', 'className'=>'Subject', 'attributeName'=>'name', 'message'=>Common::translate('validation','This subject has already existed')),
		);
	}
	
	public function attributeLabels()
	{
		return array(
				'subject' => Common::translate('register', 'Subject'),
		);
	}
	
}