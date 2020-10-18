<?php
class Subject extends BaseSubject
{
	public $is_change_parent = false;
	public $old_parent_id;
	public $old_level;
	public $old_root;
	
	const ACTIVE = 1;
	const DISABLE = 0;
	
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
	 * (non-PHPdoc)
	 * @see BaseLeads::rules()
	 */
	public function relations()
	{
		$relations = array(
				'accounts' => array(self::MANY_MANY, 'Account', 'tutor_subjects(ref_subject_id, ref_account_id)'),
		);
	
		return CMap::mergeArray(parent::relations(), $relations);
	}
	
	/**
	 * count all tutor with this subject
	 */
	public function countTutor()
	{
		$count = TutorSubject::model()->findAll('ref_subject_id = ?', array($this->id));
		$count = count($count);
		
		return $count;
	}
	
	/**
	 * save created date or updated date
	 * (non-PHPdoc)
	 * @see CActiveRecord::beforeSave()
	 */
	protected function beforeSave()
	{
		if (parent::beforeSave()) 
		{
			//save created or updated time
			if ($this->isNewRecord) 
			{
				$this->status = Subject::ACTIVE;
				$this->created = date('Y-m-d H:i:s');
			}
			else 
			{
				$this->updated = date('Y-m-d H:i:s');
					
				//change parent's status
				if($this->status == self::ACTIVE)
				{
					if($this->level > 1)
					{
						$parent = Subject::model()->findByPk($this->ref_parent_id);
				
						if($parent->status != self::ACTIVE)
						{
							$parent->status = self::ACTIVE;	
							$parent->save();
						}
					}
				}
					
			}

			//clear cache
			app()->cache->set(app()->params['cacheSubjectsId'], null);
			
			return true;
		}
	}
	
	/**
	 * show subject's parent name
	 */
	public function getParentName()
	{
		if(!empty($this->ref_parent_id))
		{
			//find subject's parent
			$parent = Subject::model()->findByPk($this->ref_parent_id);
			
			return $parent->name;
		}
		else 
			return null;
	}
	
	
	/**
	 * nest subjects
	 * @param array $exclude
	 * @return multitype:string
	 */
	public static function listNestedSubject($exclude = null)
	{	
		$criteria = new CDbCriteria();
		
		$criteria->condition = 't.status = ?';
		$criteria->params = array(self::ACTIVE);
		$criteria->order = 't.index ASC';
		
		if(!empty($exclude))
		{
			$criteria->condition .= ' AND id NOT IN (' . implode(', ', $exclude) . ')';
		}
		
		$subjects = Subject::model()->findAll($criteria);
	
		$nested_subject = array();
		foreach ($subjects as $subject)
		{
			$level = $subject->level;
				
			$str = '';
			for ($i = 2; $i <= $level; $i++)
			{
				$str .= '--';
			}
				
			$nested_subject[$subject->id] = $str . ' ' . $subject->name;
		}
		
		return $nested_subject;
	}
	
	/**
	 * return cache
	 */
	public static function getSubjectCache()
	{
		$subjects = unserialize(app()->cache->get(app()->params['cacheSubjectsId']));
	
		if(!$subjects)
		{
			$subjects = self::subjectName();
	
			app()->cache->set(app()->params['cacheSubjectsId'], serialize($subjects), app()->params['cache_expire']);
		}
	
		return $subjects;
	}
	
	/**
	 * list nested subjects in array haved key is subject's name
	 * @param array $exclude
	 */
	public static function subjectName()
	{
		$criteria = new CDbCriteria();
	
		$criteria->condition = 't.status = ?';
		$criteria->params = array(self::ACTIVE);
		$criteria->order = 't.index ASC';
	
		if(!empty($exclude))
		{
			$criteria->condition .= ' AND id NOT IN (' . implode(', ', $exclude) . ')';
		}
	
		$subjects = Subject::model()->findAll($criteria);
	
		$nested_subject = array();
		foreach ($subjects as $subject)
		{
			$level = $subject->level;
	
			$str = '';
			for ($i = 2; $i <= $level; $i++)
			{
				$str .= '--';
			}
	
			$nested_subject[$subject->name] = $str . ' ' . $subject->name;
		}
	
		return $nested_subject;
	}
	
	/**
	 * return date that subject is vailable for premium upgrade
	 */
	public function premiumAvailability()
	{
		$tutor_premium = TutorPremium::model()->find('ref_subject_id = ? AND expire_date > ?', array($this->id, strtotime(date('Y-m-d H:i:s'))));
		
		if(!empty($tutor_premium))
		{
			return date('j M Y', $tutor_premium->expire_date);
		}
		else 
		{
			return 'Now';
		}
	}
	
	/**
	 * return account id of tutor that currently premium of this subject
	 */
	public function premiumAccountId()
	{
		$criteria = new CDbCriteria();
		
		$criteria->condition = 'ref_subject_id = ? AND start_date < ? AND expire_date > ?';
		$criteria->params = array($this->id, time(), time());
		
		$tutor_premium = TutorPremium::model()->find($criteria);
		
		if(!empty($tutor_premium))
		{
			return $tutor_premium->ref_account_id;
		}
		else
		{
			return null;
		}
	}
}