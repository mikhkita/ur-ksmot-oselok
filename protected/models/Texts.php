<?php

/**
 * This is the model class for table "texts".
 *
 * The followings are the available columns in table 'texts':
 * @property integer $txt_id
 * @property string $txt_title
 * @property string $txt_text
 * @property string $txt_date
 * @property integer $txt_complete
 * @property integer $txt_words
 * @property integer $txt_author
 */
class Texts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'texts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('txt_title, txt_text, txt_date, txt_words, txt_author', 'required'),
			array('txt_complete, txt_words, txt_author', 'numerical', 'integerOnly'=>true),
			array('txt_title', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('txt_id, txt_title, txt_text, txt_date, txt_complete, txt_words, txt_author', 'safe', 'on'=>'search'),
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
			'author' => array(self::BELONGS_TO, 'User', 'txt_author'),
			'words' => array(self::HAS_MANY, 'TextWord', 'txt_id'),
			'users' => array(self::HAS_MANY, 'TextUser', 'txt_id'),
		);
	}

	public function  beforeDelete() {
        foreach ($this->users as $row) {
            $row->delete();
        }
        foreach ($this->words as $row) {
            $row->delete();
        }
        return true;
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'txt_id' => 'ID текста',
			'txt_title' => 'Заголовок',
			'txt_text' => 'Текст',
			'txt_date' => 'Дата создания',
			'txt_complete' => 'Завершен',
			'txt_words' => 'Количество слов',
			'txt_author' => 'Автор',
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

		$criteria->compare('txt_id',$this->txt_id);
		$criteria->compare('txt_title',$this->txt_title,true);
		$criteria->compare('txt_text',$this->txt_text,true);
		$criteria->compare('txt_date',$this->txt_date,true);
		$criteria->compare('txt_complete',$this->txt_complete);
		$criteria->compare('txt_words',$this->txt_words);
		$criteria->compare('txt_author',$this->txt_author);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Texts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
