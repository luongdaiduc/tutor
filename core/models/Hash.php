<?php

/**
 * This is the model class for table "hash".
 *
 * The followings are the available columns in table 'hash':
 * @property string $hash
 * @property integer $type
 * @property string $id
 * @property string $expire
 */
class Hash extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Hash the static model class
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
		return 'hash';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type', 'numerical', 'integerOnly'=>true),
			array('hash', 'length', 'max'=>32),
			array('id, expire', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hash, type, id, expire', 'safe', 'on'=>'search'),
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
			'hash' => 'Hash',
			'type' => 'Type',
			'id' => 'ID',
			'expire' => 'Expire',
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

		$criteria->compare('hash',$this->hash,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('id',$this->id,true);
		$criteria->compare('expire',$this->expire,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}