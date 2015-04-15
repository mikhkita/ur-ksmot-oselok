<?php

/**
 * This is the model class for table "words".
 *
 * The followings are the available columns in table 'words':
 * @property integer $wrd_id
 * @property string $wrd_text
 * @property string $wrd_json
 * @property integer $wrd_phrase
 */
class Words extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'words';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wrd_text', 'required'),
			array('wrd_text', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('wrd_id, wrd_text, wrd_json', 'safe', 'on'=>'search'),
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
			'texts' => array(self::HAS_MANY, 'TextWord', 'wrd_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'wrd_id' => 'Wrd',
			'wrd_text' => 'Wrd Text',
			'wrd_json' => 'Wrd Json'
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

		$criteria->compare('wrd_id',$this->wrd_id);
		$criteria->compare('wrd_text',$this->wrd_text,true);
		$criteria->compare('wrd_json',$this->wrd_json,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Words the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
