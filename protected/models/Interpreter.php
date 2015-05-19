<?php

/**
 * This is the model class for table "interpreter".
 *
 * The followings are the available columns in table 'interpreter':
 * @property string $id
 * @property string $name
 * @property string $template
 * @property string $good_type_id
 */
class Interpreter extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'interpreter';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, template, good_type_id', 'required'),
			array('name', 'length', 'max'=>255),
			array('template', 'length', 'max'=>2000),
			array('good_type_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, template, good_type_id', 'safe', 'on'=>'search'),
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
			'goodType' => array(self::BELONGS_TO, 'GoodType', 'good_type_id'),
			'exports' => array(self::HAS_MANY, 'ExportInterpreter', 'interpreter_id'),
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
			'template' => 'Шаблон',
			'good_type_id' => 'Тип товара',
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
		$criteria->compare('template',$this->template,true);
		$criteria->compare('good_type_id',$this->good_type_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Interpreter the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getArrayValue($value,$type) {
        if( $value[0] == "{" && $value[strlen($value)-1] == "}" ){
            $tmp = explode("|", substr($value, 1,-1));
            $value = ($type == "REPLACE")?[0=>array(),1=>array()]:[];
            foreach ($tmp as $v) {
                $arr = explode("=", $v);
                if( count($arr) == 2 ){
                    if( $type == "REPLACE" ){
                        $value[0][] = trim($arr[0]);
                        $value[1][] = trim($arr[1]);
                    }else{
                        $value[trim($arr[0])] = trim($arr[1]);
                    }
                }else{
                    throw new CHttpException(500,"В параметре \"".$type."\" отсутствует знак \"=\" или он присутствует больше одного раза");
                }
            }
            return $value;
        }else{
            throw new CHttpException(500,"Отсутствует одна или обе скобочки \"{}\" у значения параметра \"".$type."\"");
        }
    }

    public function generate($interpreter_id,$model){
    	$attributes = $model->fields_assoc;
    	if( isset($this->interpreters[(string)$interpreter_id]) ){
    		if( $this->interpreters[(string)$interpreter_id]->good_type_id == $model->good_type_id ){
    			$template = $this->interpreters[(string)$interpreter_id]->template;
    		}else{
    			throw new CHttpException(500,'У типа товара "'.$model->type->name.'" нет интерпретатора с идентификатором '.$interpreter_id);
    		}
    	}else{
    		throw new CHttpException(500,'Не найден интерпретатор с идентификатором '.$interpreter_id);
    	}

    	preg_match_all("~\[\+([^\+\]]+)\+\]~", $template, $matches);

		$rules = $matches[1];

		foreach ($rules as $i => $rule) {
			$tmp = explode(";", $rule);
			$params = [];
			foreach ($tmp as $param) {
				$index = stripos($param, "=");
				if( $index > 0 ){
					$key = substr($param,0,$index);
					$value = substr($param, $index+1);
					$params[trim($key)] = trim($value);
				}else{
					throw new CHttpException(500,"Отсутствует знак \"=\" у параметра \"".$param."\"");
				}
				
			}

			if( isset($params["ALT"]) ){
				$params["ALT"] = Interpreter::getArrayValue($params["ALT"],"ALT");
			}

			if( isset($params["REPLACE"]) ){
				$params["REPLACE"] = Interpreter::getArrayValue($params["REPLACE"],"REPLACE");
			}

			if( isset($params["ATTR"]) ){
				$val = ( isset($attributes[intval($params["ATTR"])]->value) )?$attributes[intval($params["ATTR"])]->value:"";

				$val = ( isset($params["FLOAT"]) )?number_format((float)$val,intval($params["FLOAT"])):$val;

				if( isset($params["REPLACE"]) ){
					$val = str_replace($params["REPLACE"][0], $params["REPLACE"][1], $val);
				}

				$matches[1][$i] = ( isset($params["ALT"]) && isset($params["ALT"][$val]) )?$params["ALT"][$val]:$val;
			}else{
				throw new CHttpException(500,"Отсутствует параметр \"ATTR\"");
			}
		}
		return str_replace($matches[0], $matches[1], $template);
    }
}
