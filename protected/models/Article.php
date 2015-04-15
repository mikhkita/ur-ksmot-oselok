<?php

/**
 * This is the model class for table "article".
 *
 * The followings are the available columns in table 'article':
 * @property integer $art_id
 * @property string $art_title
 * @property string $art_text
 * @property integer $art_hou_id
 * @property integer $art_cat_id
 * @property integer $art_active
 */
class Article extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'article';
	}

	public function defaultScope()
    {
        return array(
            'order'=>'art_id DESC',
        );
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('art_title, art_text, art_hou_id, art_cat_id', 'required'),
			array('art_hou_id, art_cat_id, art_active', 'numerical', 'integerOnly'=>true),
			array('art_title', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('art_id, art_title, art_text, art_hou_id, art_cat_id, art_active', 'safe', 'on'=>'search'),
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
			'house' => array(self::BELONGS_TO, 'House', 'art_hou_id'),
			'category' => array(self::BELONGS_TO, 'Category', 'art_cat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'art_id' => 'ID статьи',
			'art_title' => 'Заголовок',
			'art_text' => 'Текст',
			'art_hou_id' => 'Дом',
			'art_cat_id' => 'Категория',
			'art_active' => 'Активность',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('art_id',$this->art_id);
		$criteria->compare('art_title',$this->art_title,true);
		$criteria->compare('art_text',$this->art_text,true);
		$criteria->compare('art_hou_id',$this->art_hou_id);
		$criteria->compare('art_cat_id',$this->art_cat_id);
		$criteria->compare('art_active',$this->art_active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Article the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
