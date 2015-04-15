<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $usr_id
 * @property string $usr_login
 * @property string $usr_password
 * @property string $usr_email
 */
class User extends CActiveRecord
{
	const ROLE_MANAGER = 'manager';
	const ROLE_ADMIN = 'admin';
	const ROLE_ROOT = 'root';

	const STATE_ACTIVE = 1;
	const STATE_DISABLED = 0;

	public $prevRole = null;
	public $prevPass = null;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usr_login, usr_password, usr_email', 'required'),
			array('usr_login, usr_password, usr_email', 'length', 'max'=>128),
			array('usr_role, usr_name, usr_state', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('usr_id, usr_login, usr_password, usr_email, usr_role, usr_name, usr_state', 'safe', 'on'=>'search'),
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

	public function attributeLabels()
	{
		return array(
			'usr_id' => 'ID',
			'usr_login' => 'Логин',
			'usr_password' => 'Пароль',
			'usr_email' => 'E-mail',
			'usr_state' => 'Статус',
			'usr_role' => 'Роль',
			'usr_name' => 'Фамилия И.О.',
		);
	}

	public function beforeSave() {
		parent::beforeSave();
		$this->usr_password = ( $this->prevPass == $this->usr_password ) ? $this->usr_password : md5($this->usr_password."eduplan");

		if( !$this->usr_login || !$this->usr_email || !$this->usr_password || !$this->usr_state ){
	        return false;
		}
		if( ($this->usr_role == User::ROLE_ADMIN || $this->usr_role == User::ROLE_ROOT) && Controller::getUserRole() != User::ROLE_ROOT )
			throw new CHttpException(403,'Доступ запрещен');

		if( !isset($this->prevRole) ) $this->prevRole = $this->usr_role;
		return true;
	}

	public function afterSave() {
		parent::afterSave();
		//связываем нового пользователя с ролью
		$auth=Yii::app()->authManager;
		//предварительно удаляем старую связь
		$auth->revoke($this->prevRole, $this->usr_id);
		$auth->assign($this->usr_role, $this->usr_id);
		$auth->save();
		return true;
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

		$criteria->compare('usr_id',$this->usr_id);
		$criteria->compare('usr_login',$this->usr_login,true);
		$criteria->compare('usr_password',$this->usr_password,true);
		$criteria->compare('usr_email',$this->usr_email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
