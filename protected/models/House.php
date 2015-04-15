<?php

/**
 * This is the model class for table "house".
 *
 * The followings are the available columns in table 'house':
 * @property integer $hou_id
 * @property string $hou_name
 * @property integer $hou_rub_id
 * @property integer $hou_typ_id
 */
class House extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'house';
	}

	public function defaultScope()
    {
        return array(
            'order'=>'hou_id DESC',
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
			array('hou_name, hou_rub_id, hou_typ_id', 'required'),
			array('hou_rub_id, hou_typ_id', 'numerical', 'integerOnly'=>true),
			array('hou_name', 'length', 'max'=>255),
			array('hou_name, hou_rub_id, hou_typ_id', 'safe', 'on'=>'filter'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('hou_id, hou_name, hou_rub_id, hou_typ_id', 'safe', 'on'=>'search'),
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
			'rubric' => array(self::BELONGS_TO, 'Rubric', 'hou_rub_id'),
			'categories' => array(self::HAS_MANY, 'CategoryHouse', 'hou_id'),
			'articles' => array(self::HAS_MANY, 'Article', 'art_hou_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hou_id' => 'ID дома',
			'hou_name' => 'Название',
			'hou_rub_id' => 'Рубрика',
			'hou_typ_id' => 'Тип дома',
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

		$criteria->compare('hou_id',$this->hou_id);
		$criteria->compare('hou_name',$this->hou_name,true);
		$criteria->compare('hou_rub_id',$this->hou_rub_id);
		$criteria->compare('hou_typ_id',$this->hou_typ_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return House the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
