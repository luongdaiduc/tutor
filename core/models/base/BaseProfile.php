<?php

/**
 * This is the model class for table "profiles".
 *
 * The followings are the available columns in table 'profiles':
 * @property integer $id
 * @property integer $ref_account_id
 * @property string $salutation
 * @property string $gender
 * @property string $company
 * @property string $address
 * @property string $suburb
 * @property string $state
 * @property string $post_code
 * @property string $phone
 * @property string $default_hourly_rate
 * @property string $website
 * @property double $lat
 * @property double $lng
 * @property string $created
 * @property string $updated
 */
class BaseProfile extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseProfile the static model class
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
		return 'profiles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
// 			array('gender, address, state, post_code, default_hourly_rate', 'required'),
			array('ref_account_id', 'numerical', 'integerOnly'=>true),
			array('lat, lng', 'numerical'),
			array('salutation, gender, state, post_code, phone, default_hourly_rate', 'length', 'max'=>30),
			array('company, address, suburb, website', 'length', 'max'=>255),
			array('created, updated', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ref_account_id, salutation, gender, company, address, suburb, state, post_code, phone, default_hourly_rate, website, lat, lng, created, updated', 'safe', 'on'=>'search'),
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
			'salutation' => 'Salutation',
			'gender' => 'Gender',
			'company' => 'Company',
			'address' => 'Address',
			'suburb' => 'Suburb',
			'state' => 'State',
			'post_code' => 'Post Code',
			'phone' => 'Phone',
			'default_hourly_rate' => 'Default Hourly Rate',
			'website' => 'Website',
			'lat' => 'Lat',
			'lng' => 'Lng',
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
		$criteria->compare('salutation',$this->salutation,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('suburb',$this->suburb,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('post_code',$this->post_code,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('default_hourly_rate',$this->default_hourly_rate,true);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('lat',$this->lat);
		$criteria->compare('lng',$this->lng);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}