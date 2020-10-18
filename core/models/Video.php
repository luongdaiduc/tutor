<?php
class Video extends BaseVideo
{
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
	
	public function rules()
	{
		$rules = array(
 					array('video_url', 'youtubeLink'),
					array('video_url, title', 'required', 'message'=>'{attribute} ' . Common::translate('validation', 'cannot be blank')),
				);
	
		return CMap::mergeArray(parent::rules(), $rules);
	}
	
	public function attributeLabels()
	{
		$labels = array(
				'video_url' => Common::translate('account', 'URL'),
				'title' => Common::translate('account', 'Title'),
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
				//save created or updated time
				$this->created = date('Y-m-d H:i:s');
			}
			else
				$this->updated = date('Y-m-d H:i:s');
			
			return true;
		}
	}
	
	/**
	 * search video based on user id
	 * @param integer $id
	 */
	public function searchVideo($id)
	{
		$criteria=new CDbCriteria;
		
		$criteria->condition = 'ref_account_id = ?';
		$criteria->params = array($id);
		
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	/**
	 * get image thumbnail for youtube video
	 */
	public function getVideoThumbnail()
	{
		$thumbnail = explode('watch?v=', $this->video_url);
		$count = count($thumbnail);
		
		if($count > 1)
		{
			$thumbnail = $thumbnail[1];
			$thumbnail = 'http://img.youtube.com/vi/' . $thumbnail . '/1.jpg';
			
			return $thumbnail;
		}
		else 
			return null;
	}
	
	/**
	 * check whether the video url are youtube link or not
	 */
	public function youtubeLink()
	{
		$video_id = explode('watch?v=', $this->video_url);
		$count = count($video_id);
		
		if($count > 1)
		{
			$check_link = 'gdata.youtube.com/feeds/api/videos/' . $video_id[1];
			
			//** curl the check link ***//
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$check_link);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 5);
			$result = curl_exec($ch);
			curl_close($ch);
			
			if(trim($result) == 'Invalid id')
			{
				$this->addError('video_url', Common::translate('validation', 'Invalid link'));
			}
		}
		else 
		{
			$this->addError('video_url', Common::translate('validation', 'Invalid link'));
		}
	}
}