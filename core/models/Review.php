<?php
class Review extends BaseReview
{
	const ACTIVE = 1;
	const INACTIVE = 0;
	const REQUEST_REMOVAL = 2;
	const SYSTEM = 'system';
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see BaseLeads::rules()
	 */
	public function relations()
	{
		$relations = array(
			
		);
	
		return CMap::mergeArray(parent::relations(), $relations);
	}
	
	public function attributeLabels()
	{
		$labels = array(
				'rating' => Common::translate('profile', 'Rating'),
				'content' => Common::translate('profile', 'Content'),
		);
	
		return CMap::mergeArray(parent::attributeLabels(), $labels);
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
	
	protected function afterSave()
	{
		$this->averageRating();
	}
	
	protected function afterDelete()
	{
		$this->averageRating();
	}
	
	/**
	 * calculate tutor average rating
	 */
	public function averageRating()
	{
		$query = app()->db->createCommand()
		->select('SUM(u.rating) AS total, COUNT(*) as cnt')
		->from(Review::model()->tableName() .' u')
		->where('u.ref_account_id = '. $this->ref_account_id . ' AND status <> ' . self::INACTIVE)
		->queryRow();
			
		if (!empty($query))
		{
			$total = $query['total'];
			$cnt = $query['cnt'];
		
			$account = Account::model()->findByPk($this->ref_account_id);
		
			if($cnt>0)
			{
				$rating = $total/$cnt;
				$account->rating = $rating;
			}
			else
			{
				$account->rating = 0;
			}
		
			$account->save(false);
		}
			
	}
	
	/**
	 * show all tutor review
	 * @param integer $ref_account_id
	 */
	public function searchReview($ref_account_id)
	{
		$criteria = new CDbCriteria();
		
		$criteria->condition = 'ref_account_id = ? AND t.status <> ?';
		$criteria->params = array($ref_account_id, self::INACTIVE);
		
		$criteria->order = 'created DESC, updated DESC';
		
		return new CActiveDataProvider($this, array('criteria'=>$criteria, 'pagination'=>array('pagesize'=>10)));
	}
	
	/**
	 * search all request remove review
	 * @param string $ids
	 */
	public function searchRequestRemove($ids)
	{
		$criteria = new CDbCriteria();
	
		$criteria->condition = 't.id IN (' . $ids . ')';
	
		$criteria->order = 'created DESC';
	
		return new CActiveDataProvider($this, array('criteria'=>$criteria, 'pagination'=>array('pagesize'=>10)));
	}
	
	/**
	 * make sure that user can rate a tutor one time for each provider
	 * @param int $ref_account_id
	 * @param string $login_id
	 * @param string $provider
	 */
	public function isRated($ref_account_id, $login_id, $provider)
	{
		$is_rated = Review::model()->exists('ref_account_id = ? AND login_provider_id = ? AND provider = ?', array($ref_account_id, $login_id, $provider));
		
		return $is_rated;
	}
	
	/**
	 * show star base on tutor's rating
	 * @param integer $rating
	 */
	public function showStar($rating)
	{
		$active_star = $rating;
		$inactive_star = 5 - $rating;
			
		$star = '';
		for($i=1; $i<=$active_star; $i++) {
			$star .= '<div class="active_star"></div>';
		}
		for($i=1; $i<=$inactive_star; $i++) {
			$star .= '<div class="inactive_star"></div>';
		}
			
		return $star;
	}
}