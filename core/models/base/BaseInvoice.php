<?php

/**
 * This is the model class for table "invoices".
 *
 * The followings are the available columns in table 'invoices':
 * @property integer $id
 * @property integer $ref_account_id
 * @property integer $account_type
 * @property integer $ref_transaction_id
 * @property string $subscription_subject_ids
 * @property string $expire_day
 * @property string $amount
 * @property string $currency
 * @property string $created
 */
class BaseInvoice extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseInvoice the static model class
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
		return 'invoices';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ref_account_id, account_type, ref_transaction_id', 'numerical', 'integerOnly'=>true),
			array('subscription_subject_ids', 'length', 'max'=>255),
			array('amount, currency', 'length', 'max'=>30),
			array('expire_day, created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ref_account_id, account_type, ref_transaction_id, subscription_subject_ids, expire_day, amount, currency, created', 'safe', 'on'=>'search'),
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
			'account_type' => 'Account Type',
			'ref_transaction_id' => 'Ref Transaction',
			'subscription_subject_ids' => 'Subscription Subject Ids',
			'expire_day' => 'Expire Day',
			'amount' => 'Amount',
			'currency' => 'Currency',
			'created' => 'Created',
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
		$criteria->compare('account_type',$this->account_type);
		$criteria->compare('ref_transaction_id',$this->ref_transaction_id);
		$criteria->compare('subscription_subject_ids',$this->subscription_subject_ids,true);
		$criteria->compare('expire_day',$this->expire_day,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}