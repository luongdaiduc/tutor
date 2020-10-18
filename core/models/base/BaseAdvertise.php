<?php

/**
 * This is the model class for table "advertises".
 *
 * The followings are the available columns in table 'advertises':
 * @property integer $id
 * @property integer $ref_account_id
 * @property string $domain
 * @property string $title
 * @property string $summary
 * @property string $detail
 * @property string $audiences
 * @property string $created
 * @property string $updated
 */
class BaseAdvertise extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseAdvertise the static model class
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
		return 'advertises';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
// 			array('ref_account_id, title, summary, detail, audiences', 'required'),
			array('ref_account_id', 'numerical', 'integerOnly'=>true),
			array('domain, title, audiences', 'length', 'max'=>255),
			array('created, updated', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ref_account_id, domain, title, summary, detail, audiences, created, updated', 'safe', 'on'=>'search'),
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
			'domain' => 'Domain',
			'title' => 'Title',
			'summary' => 'Summary',
			'detail' => 'Detail',
			'audiences' => 'Audiences',
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
		$criteria->compare('domain',$this->domain,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('summary',$this->summary,true);
		$criteria->compare('detail',$this->detail,true);
		$criteria->compare('audiences',$this->audiences,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}