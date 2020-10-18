<?php
class ReplyForm extends CFormModel
{
	public $subject;
	public $content;
		
	public function rules()
	{
		return array(
			array('subject, content', 'required'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
		);
	}
	
}