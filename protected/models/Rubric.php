<?php

/**
 * This is the model class for table "rubric".
 *
 * The followings are the available columns in table 'rubric':
 * @property integer $rub_id
 * @property string $rub_name
 * @property string $rub_img
 * @property integer $rub_sort
 */
class Rubric extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rubric';
	}

	public function defaultScope()
    {
        return array(
            'order'=>'rub_sort ASC',
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
			array('rub_name, rub_sort', 'required'),
			array('rub_sort', 'numerical', 'integerOnly'=>true),
			array('rub_name, rub_img', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('rub_id, rub_name, rub_img, rub_sort', 'safe', 'on'=>'search'),
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
			'houses' => array(self::HAS_MANY, 'House', 'hou_rub_id', 'order' => 'hou_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rub_id' => 'ID рубрики',
			'rub_name' => 'Название',
			'rub_img' => 'Изображение',
			'rub_sort' => 'Сортировка',
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

		$criteria->compare('rub_id',$this->rub_id);
		$criteria->compare('rub_name',$this->rub_name,true);
		$criteria->compare('rub_img',$this->rub_img,true);
		$criteria->compare('rub_sort',$this->rub_sort);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeDelete() {
        if(file_exists($this->rub_img)) unlink($this->rub_img);
        return true;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Rubric the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
