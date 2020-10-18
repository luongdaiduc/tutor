<?php

/**
 * This is the model class for table "queues".
 *
 * The followings are the available columns in table 'queues':
 * @property integer $id
 * @property string $sender_email
 * @property string $sender_name
 * @property string $recipient_email
 * @property string $recipient_name
 * @property string $title
 * @property string $message
 * @property integer $status
 * @property string $created
 * @property string $updated
 */
class BaseQueue extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseQueue the static model class
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
		return 'queues';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('recipient_email, recipient_name', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('sender_email, sender_name, recipient_email, recipient_name, title', 'length', 'max'=>255),
			array('message, created, updated', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, sender_email, sender_name, recipient_email, recipient_name, title, message, status, created, updated', 'safe', 'on'=>'search'),
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
			'sender_email' => 'Sender Email',
			'sender_name' => 'Sender Name',
			'recipient_email' => 'Recipient Email',
			'recipient_name' => 'Recipient Name',
			'title' => 'Title',
			'message' => 'Message',
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
		$criteria->compare('sender_email',$this->sender_email,true);
		$criteria->compare('sender_name',$this->sender_name,true);
		$criteria->compare('recipient_email',$this->recipient_email,true);
		$criteria->compare('recipient_name',$this->recipient_name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}