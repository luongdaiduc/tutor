<?php

/**
 * This is the model class for table "accounts".
 *
 * The followings are the available columns in table 'accounts':
 * @property integer $id
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $password
 * @property string $rating
 * @property integer $status
 * @property integer $is_feature
 * @property integer $is_enhance
 * @property string $enhance_start
 * @property string $enhance_expire
 * @property integer $is_premium
 * @property string $premium_start
 * @property string $premium_expire
 * @property integer $role
 * @property string $created
 * @property string $updated
 * @property string $last_login
 * @property string $previous_login
 */
class BaseAccount extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseAccount the static model class
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
		return 'accounts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, password, role', 'required'),
			array('status, is_feature, is_enhance, is_premium, role', 'numerical', 'integerOnly'=>true),
			array('email, first_name, last_name, password', 'length', 'max'=>255),
			array('rating', 'length', 'max'=>10),
			array('enhance_start, enhance_expire, premium_start, premium_expire', 'length', 'max'=>20),
			array('created, updated, last_login, previous_login', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email, first_name, last_name, password, rating, status, is_feature, is_enhance, enhance_start, enhance_expire, is_premium, premium_start, premium_expire, role, created, updated, last_login, previous_login', 'safe', 'on'=>'search'),
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
			'email' => 'Email',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'password' => 'Password',
			'rating' => 'Rating',
			'status' => 'Status',
			'is_feature' => 'Is Feature',
			'is_enhance' => 'Is Enhance',
			'enhance_start' => 'Enhance Start',
			'enhance_expire' => 'Enhance Expire',
			'is_premium' => 'Is Premium',
			'premium_start' => 'Premium Start',
			'premium_expire' => 'Premium Expire',
			'role' => 'Role',
			'created' => 'Created',
			'updated' => 'Updated',
			'last_login' => 'Last Login',
			'previous_login' => 'Previous Login',
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('rating',$this->rating,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('is_feature',$this->is_feature);
		$criteria->compare('is_enhance',$this->is_enhance);
		$criteria->compare('enhance_start',$this->enhance_start,true);
		$criteria->compare('enhance_expire',$this->enhance_expire,true);
		$criteria->compare('is_premium',$this->is_premium);
		$criteria->compare('premium_start',$this->premium_start,true);
		$criteria->compare('premium_expire',$this->premium_expire,true);
		$criteria->compare('role',$this->role);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('last_login',$this->last_login,true);
		$criteria->compare('previous_login',$this->previous_login,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}