<?php

/**
 * This is the model class for table "tutor_subjects".
 *
 * The followings are the available columns in table 'tutor_subjects':
 * @property integer $id
 * @property integer $ref_account_id
 * @property integer $ref_subject_id
 * @property integer $experience
 * @property string $level
 * @property integer $hourly_rate
 * @property integer $status
 * @property string $created
 * @property string $updated
 */
class BaseTutorSubject extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseTutorSubject the static model class
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
		return 'tutor_subjects';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
// 			array('ref_account_id, ref_subject_id, experience, hourly_rate, status', 'numerical', 'integerOnly'=>true),
			array('level', 'length', 'max'=>30),
			array('created, updated', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ref_account_id, ref_subject_id, experience, level, hourly_rate, status, created, updated', 'safe', 'on'=>'search'),
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
			'experience' => 'Experience',
			'level' => 'Level',
			'hourly_rate' => 'Hourly Rate',
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
		$criteria->compare('ref_subject_id',$this->ref_subject_id);
		$criteria->compare('experience',$this->experience);
		$criteria->compare('level',$this->level,true);
		$criteria->compare('hourly_rate',$this->hourly_rate);
		$criteria->compare('status',$this->status);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}