<?php

/**
 * This is the model class for table "attribute".
 *
 * The followings are the available columns in table 'attribute':
 * @property string $id
 * @property string $name
 * @property string $code
 * @property integer $attribute_type_id
 * @property integer $multi
 * @property integer $list
 */
class Attribute extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'attribute';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, attribute_type_id', 'required'),
			array('attribute_type_id, multi, list', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, attribute_type_id, multi, list', 'safe', 'on'=>'search'),
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
			'goods' => array(self::HAS_MANY, 'GoodAttribute', 'attribute_id'),
			'goodTypes' => array(self::HAS_MANY, 'GoodTypeAttribute', 'attribute_id'),
			'type' => array(self::BELONGS_TO, 'AttributeType', 'attribute_type_id'),
			'variants' => array(self::HAS_MANY, 'AttributeVariant', 'attribute_id','order'=>'sort'),
			'exports' => array(self::HAS_MANY, 'ExportAttribute', 'attribute_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'attribute_type_id' => 'Тип данных',
			'multi' => 'Множественный',
			'list' => 'Список'
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('attribute_type_id',$this->attribute_type_id);
		$criteria->compare('multi',$this->multi);
		$criteria->compare('list',$this->list);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Attribute the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function beforeSave(){
  		if( $this->type->code == "text" ) $this->setAttribute("list",0);
  		return parent::beforeSave();
 	}
}
