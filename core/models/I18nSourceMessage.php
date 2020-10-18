<?php

/**
 * This is the model class for table "i18n_source_messages".
 *
 * The followings are the available columns in table 'i18n_source_messages':
 * @property integer $id
 * @property string $category
 * @property string $message
 *
 * The followings are the available model relations:
 * @property I18nMessages[] $i18nMessages
 */
class I18nSourceMessage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return I18nSourceMessage the static model class
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
		return 'i18n_source_messages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category', 'length', 'max'=>32),
			array('message', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, category, message', 'safe', 'on'=>'search'),
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
			'i18nMessages' => array(self::HAS_MANY, 'I18nMessages', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category' => 'Category',
			'message' => 'Message',
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
		$criteria->compare('category',$this->category,true);
		$criteria->compare('message',$this->message,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * return cache
	 */
	public static function getCategoryCache()
	{
		$categories = unserialize(app()->cache->get(app()->params['cacheCategoryId']));
	
		if(!$categories)
		{
			$criteria = new CDbCriteria();
				
			$criteria->select = 'category';
			$criteria->distinct = true;
			
			$models = I18nSourceMessage::model()->findAll($criteria);
			
			if(!empty($models))
			{
				foreach ($models as $model)
				{
					$categories[] = $model->category;
				}
			}
			app()->cache->set(app()->params['cacheCategoryId'], serialize($categories), app()->params['cache_expire']);
		}
	
		return $categories;
	}
	
	/**
	 * return translate message
	 * @return string
	 */
	public function getTranslateMessage()
	{
		$criteria = new CDbCriteria();
		
		$criteria->condition = 't.id = ? AND t.language = ?';
		$criteria->params = array($this->id, app()->controller->settings['language']);
		
		$translate_message = I18nMessage::model()->find($criteria);
		
		if(!empty($translate_message))
		{
			return $translate_message->translation;
		}
		else return '';
	}
}