<?php
class Account extends BaseAccount
{
	public $allSubjects = '';
	public $subject = array();
	
	const IS_FEATURE = 1;
	
	const TUTOR = 0;
	const ADMIN = 1;
	
	const ACTIVE = 1;
	const INACTIVE = 0;
	const HIDE = 2;
	const AWAITING = 3;
	
	//account type
	const BASIC = 0;
	const ENHANCE = 1;
	const PREMIUM = 1;
	
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
				'profiles' => array(self::HAS_ONE, 'Profile', 'ref_account_id'),
				'advertises' => array(self::HAS_ONE, 'Advertise', 'ref_account_id'),
				'subjects' => array(self::MANY_MANY, 'Subject', 'tutor_subjects(ref_account_id, ref_subject_id)'),
				'tutor_subjects' => array(self::HAS_MANY, 'TutorSubject', 'ref_account_id'),
				'photos' => array(self::HAS_MANY, 'Gallery', 'ref_account_id'),
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
	 * save created date or updated date
	 * (non-PHPdoc)
	 * @see CActiveRecord::beforeSave()
	 */
	protected function beforeSave()
	{
		if (parent::beforeSave()) {
			if ($this->isNewRecord) {
				$this->created = date('Y-m-d H:i:s');
			}
			else
				$this->updated = date('Y-m-d H:i:s');
			return true;
		}
	}
	
	/**
	 * search all tutor for user management in admin page
	 */
	public function searchAllTutor()
	{
		$criteria = new CDbCriteria();
		$criteria->condition = 'role = ?';
		$criteria->params = array(Account::TUTOR);
		$criteria->order = 'created desc';
		
		return new CActiveDataProvider($this, array('criteria'=>$criteria, 'pagination'=>array('pagesize'=>20)));
	}
	
	/**
	 * list all subject of tutor
	 * (non-PHPdoc)
	 * @see CActiveRecord::afterFind()
	 */
	public function afterFind() {
		parent::afterFind();
	
		$tutor_subjects = TutorSubject::model()->findAll('ref_account_id = ? and t.status = ?', array($this->id, TutorSubject::ACTIVE));
		
		if(!empty($tutor_subjects))
		{
			$list = array();
			foreach ($tutor_subjects as $value)
			{
				if(!in_array($value->subjects->name, $list) && count($list) < 5)
					$list[] = $value->subjects->name;
			}
			
			$this->allSubjects = count($tutor_subjects) <= 5 ?  implode(', ', $list) : implode(', ', $list) . ' and more subjects.';
		}
		
	}
	
	/**
	 * return tutor profile link, use subdomain for featured tutor
	 * @param integer $ref_account_id
	 * @param bool $absoluteUrl
	 */
	public static function profileLink($ref_account_id, $action = '/tutor/detail', $absoluteUrl = FALSE)
	{
		$account = Account::model()->findByPk($ref_account_id);
		
		//check whether tutor is enhanced or premium 
		if($account->is_enhance == Account::ENHANCE || $account->isPremium($account->id))
		{
			return aUrl($action, array('domain'=>$account->advertises->domain));
		}
		else 
		{
			return url($action, array('id'=>$ref_account_id), $absoluteUrl);
		}
	}
	
	/**
	 * check whether tutor is featured or not
	 */
	public function isFeature($id)
	{
		$account = Account::model()->findByPk($id);
		
		if($account->is_enhance == Account::ENHANCE || $account->isPremium($id))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	/**
	 * check whether account is premium/premium of a subject or not
	 * @param integer $id
	 */
	public function isPremium($id, $subject_name = NULL)
	{
		$criteria = new CDbCriteria();
		$criteria->condition = 'ref_account_id = ? AND start_date < ? AND expire_date > ?';
		$criteria->params = array($id, time(), time());
		
		if(!empty($subject_name))
		{
			$subject = Subject::model()->find('name = ? AND t.status = ?', array($subject_name, Subject::ACTIVE));
			
			$criteria->condition .= ' AND ref_subject_id = ' . $subject->id;
		}
		
		$premium = TutorPremium::model()->find($criteria);
		
		if(!empty($premium))
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
	
	/**
	 * check whether tutor has photo or not
	 */
	public function hasGallery()
	{
		$gallery = Gallery::model()->find('ref_account_id = ?', array($this->id));
		
		if(!empty($gallery))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * check whether tutor has video or not
	 */
	public function hasVideo()
	{
		$video = Video::model()->find('ref_account_id = ?', array($this->id));
	
		if(!empty($video))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * return the amount that user had paid
	 */
	public function paidAmount()
	{
		$invoices = Invoice::model()->findAll('ref_account_id = ?', array($this->id));
		
		$total_amount = '';
		
		if(!empty($invoices))
		{
			foreach($invoices as $invoice)
			{
				$total_amount += $invoice->amount;
			}
		}
		
		return !empty($total_amount) ? Common::formatCurrency($total_amount) : $total_amount;
	}
	
	/**
	 * create tutor profile view
	 * @param int $type
	 */
	public function increaseTutorStatistic($type)
	{
		//update tutor's profile view
		$tutor_statistic = new TutorStatistic();
		$tutor_statistic->ref_account_id = $this->id;
		$tutor_statistic->type = $type;
		$tutor_statistic->save();
	}
	
	/**
	 * count tutor statistic
	 * @param int $statistic_type
	 * @param int $time_type
	 * @param date $time
	 */
	public function tutorStatistic($statistic_type, $time_type, $time=NULL)
	{
		$criteria = new CDbCriteria();
		
		if($time_type == 'month')
		{
			$criteria->condition = 'type = ? AND MONTH(created) = ? AND ref_account_id = ?';
			$criteria->params = array($statistic_type, $time, $this->id);
		}
		
		if($time_type == 'year')
		{
			$criteria->condition = 'type = ? AND YEAR(created) = ? AND ref_account_id = ?';
			$criteria->params = array($statistic_type, $time, $this->id);
		}
		
		if($time_type == 'all')
		{
			$criteria->condition = 'type = ? AND ref_account_id = ?';
			$criteria->params = array($statistic_type, $this->id);
		}
		
		$count = TutorStatistic::model()->count($criteria);
		
		return $count;
	}
	
}