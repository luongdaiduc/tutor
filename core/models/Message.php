<?php
class Message extends BaseMessage
{
	const READ = 1;
	const UNREAD = 0;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function relations()
	{
		$relations = array(
				'accounts' => array(self::BELONGS_TO, 'Account', 'send_by'),
		);
	
		return CMap::mergeArray(parent::relations(), $relations);
	}
	
	public function rules()
	{
		$rules = array(
				
		);
	
		return CMap::mergeArray(parent::rules(), $rules);
	}
	
	/**
	 * get the previous message id
	 */
	public function prevMessage()
	{
		$criteria = new CDbCriteria();
		$criteria->condition = 'id < ?';
		$criteria->params = array($this->id);
		$criteria->order = 'id Desc';
		$prev = $this->find($criteria);

		if(!empty($prev))
			return $prev->id;
		else
			return '';
	}
	
	/**
	 * get the next message id
	 */
	public function nextMessage()
	{
		$next = $this->find('id > ?', array($this->id));
	
		if(!empty($next))
			return $next->id;
		else
			return '';
	}
	
	/**
	 * get first message id
	 */
	public function firstMessage()
	{
		$criteria = new CDbCriteria();
		$criteria->order = 'id Asc';
		
		$first = $this->find($criteria);
		
		return $first->id;
	}
	
	/**
	 * get last message id
	 */
	public function lastMessage()
	{
		$criteria = new CDbCriteria();
		$criteria->order = 'id Desc';
	
		$last = $this->find($criteria);
	
		return $last->id;
	}
	
	/**
	 * count all unread message
	 */
	public static function countAllUnreadMessage()
	{
		$messages = Message::model()->count('is_read = ?', array(Message::UNREAD));
	
		return $messages;
	}
}