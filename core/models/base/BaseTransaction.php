<?php

/**
 * This is the model class for table "transaction".
 *
 * The followings are the available columns in table 'transaction':
 * @property string $id
 * @property integer $ref_account_id
 * @property string $txn_id
 * @property string $payment_status
 * @property string $payment_date
 * @property string $mc_gross
 * @property string $info
 * @property integer $status
 */
class BaseTransaction extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseTransaction the static model class
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
		return 'transaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('txn_id, payment_status, payment_date, mc_gross, info', 'required'),
			array('ref_account_id, status', 'numerical', 'integerOnly'=>true),
			array('txn_id, payment_date', 'length', 'max'=>64),
			array('payment_status', 'length', 'max'=>16),
			array('mc_gross', 'length', 'max'=>6),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ref_account_id, txn_id, payment_status, payment_date, mc_gross, info, status', 'safe', 'on'=>'search'),
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
			'txn_id' => 'Txn',
			'payment_status' => 'Payment Status',
			'payment_date' => 'Payment Date',
			'mc_gross' => 'Mc Gross',
			'info' => 'Info',
			'status' => 'Status',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('ref_account_id',$this->ref_account_id);
		$criteria->compare('txn_id',$this->txn_id,true);
		$criteria->compare('payment_status',$this->payment_status,true);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('mc_gross',$this->mc_gross,true);
		$criteria->compare('info',$this->info,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}