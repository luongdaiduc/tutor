<?php

/**
 * This is the model class for table "reviews".
 *
 * The followings are the available columns in table 'reviews':
 * @property integer $id
 * @property integer $ref_account_id
 * @property string $post_by
 * @property integer $rating
 * @property string $content
 * @property string $login_provider_id
 * @property string $provider
 * @property integer $status
 * @property string $created
 * @property string $updated
 */
class BaseReview extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseReview the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'reviews';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rating, content', 'required', 'message'=>'{attribute} ' . Common::translate('validation', 'cannot be blank')),
			array('ref_account_id, rating, status', 'numerical', 'integerOnly'=>true),
			array('post_by, login_provider_id, provider', 'length', 'max'=>255),
			array('created, updated', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ref_account_id, post_by, rating, content, login_provider_id, provider, status, created, updated', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ref_account_id' => 'Ref Account',
			'post_by' => 'Post By',
			'rating' => 'Rating',
			'content' => 'Content',
			'login_provider_id' => 'Login Provider',
			'provider' => 'Provider',
			'status' => 'Status',
			'created' => 'Created',
			'updated' => 'Updated',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('ref_account_id',$this->ref_account_id);
		$criteria->compare('post_by',$this->post_by,true);
		$criteria->compare('rating',$this->rating);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('login_provider_id',$this->login_provider_id,true);
		$criteria->compare('provider',$this->provider,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}