<?php

/**
 * This is the model class for table "tutor_premiums".
 *
 * The followings are the available columns in table 'tutor_premiums':
 * @property integer $id
 * @property integer $ref_account_id
 * @property integer $ref_subject_id
 * @property integer $ref_subscription_id
 * @property string $start_date
 * @property string $expire_date
 */
class BaseTutorPremium extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseTutorPremium the static model class
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
		return 'tutor_premiums';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ref_account_id, ref_subject_id, ref_subscription_id', 'numerical', 'integerOnly'=>true),
			array('start_date, expire_date', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ref_account_id, ref_subject_id, ref_subscription_id, start_date, expire_date', 'safe', 'on'=>'search'),
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
			'ref_subject_id' => 'Ref Subject',
			'ref_subscription_id' => 'Ref Subscription',
			'start_date' => 'Start Date',
			'expire_date' => 'Expire Date',
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
		$criteria->compare('ref_subject_id',$this->ref_subject_id);
		$criteria->compare('ref_subscription_id',$this->ref_subscription_id);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('expire_date',$this->expire_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}