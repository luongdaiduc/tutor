<?php
class Queue extends BaseQueue
{
	const PENDING = 0;
	const SUCCESS = 1;
	const ALL_TUTOR = 'All Tutors';
	const ACTIVE_TUTOR = 'Active Tutors';
	const SELECTED_TUTOR = 'Selected Tutors';
	
	public $active_db = 'db';
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getDbConnection()
	{
		if($this->active_db != 'db')
		{
			$db = Yii::app()->{$this->active_db};
			if ($db instanceof CDbConnection) {
				$db->setActive(true);
				return $db;
			}
		}
		else
		{
			$db = Yii::app()->db;
			if ($db instanceof CDbConnection) {
				$db->setActive(true);
				return $db;
			}
		}
	}
	
	/**
	 * save created date or updated date
	 * (non-PHPdoc)
	 * @see CActiveRecord::beforeSave()
	 */
	protected function beforeSave()
	{
		if (parent::beforeSave()) {
	
			if ($this->isNewRecord) {
				//save created or updated time
				$this->created = date('Y-m-d H:i:s');
			}
			else
				$this->updated = date('Y-m-d H:i:s');
				
			return true;
		}
	}
	
	public function searchQueue()
	{
		$criteria = new CDbCriteria();
		
		$criteria->order = 'status Asc, created Desc';
		
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	/**
	 * get the previous queue id
	 */
	public function prevQueue()
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
	 * get the next queue id
	 */
	public function nextQueue()
	{
		$next = $this->find('id > ?', array($this->id));
	
		if(!empty($next))
			return $next->id;
		else
			return '';
	}
	
	/**
	 * get first queue id
	 */
	public function firstQueue()
	{
		$criteria = new CDbCriteria();
		$criteria->order = 'id Asc';
	
		$first = $this->find($criteria);
	
		return $first->id;
	}
	
	/**
	 * get last queue id
	 */
	public function lastQueue()
	{
		$criteria = new CDbCriteria();
		$criteria->order = 'id Desc';
	
		$last = $this->find($criteria);
	
		return $last->id;
	}
	
	/**
	 * show all tutor
	 * @param string $recipient_mails
	 */
	public function showSelectedTutor($recipient_mails)
	{
		$recipient_mails = explode(',', $recipient_mails);
		$html = '';
		if(!empty($recipient_mails))
		{
			foreach ($recipient_mails as $recipient_mail)
			{
				$account = Account::model()->find('LOWER(email) = ? AND role = ? AND t.status = ?', array(strtolower($recipient_mail), Account::TUTOR, Account::ACTIVE));
				
				$html .= '<tr>
							<td>' . CHtml::link($account->first_name . " " . $account->last_name, app()->controller->siteUrl . url("/tutor/detail", array("id"=>$account->id)), array('target'=>'_blank')) . '</td>
							<td>' . $recipient_mail . '</td>
						</tr>';
			}
		}
		
		return $html;
	}
}