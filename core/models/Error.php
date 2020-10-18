<?php
class Error extends BaseError
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * get the previous error id
	 */
	public function prevError()
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
	 * get the next error id
	 */
	public function nextError()
	{
		$next = $this->find('id > ?', array($this->id));
	
		if(!empty($next))
			return $next->id;
		else
			return '';
	}
	
	/**
	 * get first error id
	 */
	public function firstError()
	{
		$criteria = new CDbCriteria();
		$criteria->order = 'id Asc';
	
		$first = $this->find($criteria);
	
		return $first->id;
	}
	
	/**
	 * get last error id
	 */
	public function lastError()
	{
		$criteria = new CDbCriteria();
		$criteria->order = 'id Desc';
	
		$last = $this->find($criteria);
	
		return $last->id;
	}
	
	public function searchError()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
	
		$criteria=new CDbCriteria;
	
		$criteria->order = 'created DESC';
	
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}