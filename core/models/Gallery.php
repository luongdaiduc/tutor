<?php
class Gallery extends BaseGallery
{
	const IS_FAVOURITE = 1;
	public $streamPhoto;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function rules()
	{
		$rules = array(
				array('streamPhoto', 'file', 'allowEmpty'=>false, 'maxSize'=>1024*1024*2, 'tooLarge'=>'File size is larger than 2MB', 'types'=>array('gif', 'png', 'jpeg', 'jpg'), 'wrongType'=>'Invalid File Type.', 'on'=>'create'),
		);
	
		return CMap::mergeArray(parent::rules(), $rules);
	}
	
	public function relations()
	{
		$relations = array(
				'accounts' => array(self::BELONGS_TO, 'Account', 'ref_account_id'),
		);
	
		return CMap::mergeArray(parent::relations(), $relations);
	}
	
	public function attributeLabels()
	{
		$labels = array(
				'streamPhoto' => Common::translate('account', 'Image'),
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
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPhoto()
	{
		$criteria=new CDbCriteria;
	
		$criteria->condition = 'ref_account_id = ?';
		$criteria->params = array(app()->user->id);
	
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	/**
	 * return image used to set avatar of tutor
	 */
	public function getAvatar($account_id)
	{
		$avatar = '';
		
		$criteria = new CDbCriteria();
		$criteria->condition = 'ref_account_id = ? and is_favourite = ?';
		$criteria->params = array($account_id, self::IS_FAVOURITE);
		$criteria->order = 'rand()';
		
		//check whether tutor has a favourite photo or not
		$favourite_photo = Gallery::model()->find($criteria);
		
		if(!empty($favourite_photo))
		{
			$avatar = $favourite_photo->photo;
		}
		else
		{
			$criteria = new CDbCriteria();
			$criteria->condition = 'ref_account_id = ?';
			$criteria->params = array($account_id);
			$criteria->order = 'rand()';
			
			$gallery = Gallery::model()->find($criteria);
	
			if(!empty($gallery))
			{
				$avatar = $gallery->photo;
			}
			else
			{
				$avatar = null;
			}
		}
		
		return $avatar;
	}
	
}