<?php

class ExportController extends Controller
{
	public function filters()
	{
		return array(
				'accessControl'
			);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('adminIndex','adminCreate','adminUpdate','adminDelete','adminGetFields'),
				'roles'=>array('manager'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public function getFields($goodTypeId = false){
		if( !$goodTypeId ){
			$model = GoodType::model()->findAll(array("limit"=>1));
			$goodTypeId = $model[0]->id;
		}
		$model = GoodType::model()->with("fields.attribute","interpreters")->findByPk($goodTypeId);
		$attributes = array();

		foreach ($model->fields as $key => $value) {
			$value = $value->attribute;
			$attributes[$value->id."a"] = $value;
		}
		foreach ($model->interpreters as $key => $value) {
			$attributes[$value->id."i"] = $value;
		}

		return $attributes;
	}

	public function getModelFields($model){
		$attributes = array();
		$sorter = array();

		$prevMin = -9999999;
		$minElem = NULL;

		// Ебаная сортировка
		for( $i = 0 ; $i < count($model->fields)+count($model->interpreters) ; $i++ ){
			$min = 9999999;

			foreach ($model->fields as $key => $value) {
				if( (int)$value->sort < $min && (int)$value->sort > $prevMin ){
					$min = (int)$value->sort;
					$minElem = array("key"=>$value->attribute_id."a", "value" => $value->attribute);
				}
			}

			foreach ($model->interpreters as $key => $value) {
				if( (int)$value->sort < $min && (int)$value->sort > $prevMin ){
					$min = (int)$value->sort;
					$minElem = array("key"=>$value->interpreter_id."i", "value" => $value->interpreter);
				}
			}

			$prevMin = $min;
			$attributes[$minElem["key"]] = $minElem["value"];
		}

		return $attributes;
	}

	public function actionAdminGetFields($goodTypeId){
		$this->renderPartial('adminGetFields',array(
			'allAttr'=>$this->getFields($goodTypeId)
		));
	}

	public function actionAdminCreate()
	{
		$model=new Export;

		if(isset($_POST['Export']))
		{
			$this->setAttr($model);
		}else{
			$attr = array();

			$allAttr = $this->getFields();

			$this->renderPartial('adminCreate',array(
				'model'=>$model,
				'attr'=> $attr,
				'allAttr'=>$allAttr
			));
		}
	}

	public function actionAdminUpdate($id)
	{
		$model=Export::model()->with("fields.attribute","interpreters.interpreter")->findByPk($id);

		if(isset($_POST['Export']))
		{
			$this->setAttr($model);
		}else{
			$attr = $this->getModelFields($model);
			$allAttr = array_diff_key($this->getFields($model->good_type_id), $attr);

			$this->renderPartial('adminUpdate',array(
				'model'=>$model,
				'allAttr'=>$allAttr,
				'attr'=>$attr
			));
		}
	}

	public function setAttr($model){
		$model->attributes=$_POST['Export'];
		if($model->save()){
			$this->updateAttributes($model);
			$this->actionAdminIndex(true);
		}
	}

	public function updateAttributes($model){
		ExportAttribute::model()->deleteAll('export_id='.$model->id);
		ExportInterpreter::model()->deleteAll('export_id='.$model->id);

		if( isset($_POST["sorted"]) ){
			$values = array("attributes"=>array(),"interpreters"=>array());

			$sort = 10;
			if( isset($_POST["sorted"]) ){
				foreach ($_POST["sorted"] as $key => $value) {
					$tmpArr = explode("-", $value);

					$values[$tmpArr[0]][] = "('".$model->id."','".$tmpArr[1]."','".$sort."')";
					$sort+=10;
				}
			}

			if( count($values["attributes"]) )
				$this->insertAll($tableName = ExportAttribute::tableName(),$values["attributes"]);

			if( count($values["interpreters"]) )
				$this->insertAll($tableName = ExportInterpreter::tableName(),$values["interpreters"]);
		}
	}

	public function insertAll($tableName,$values){
		$sql = "INSERT INTO `$tableName` VALUES ";

		$sql .= implode(",", $values);

		Yii::app()->db->createCommand($sql)->execute();
	}

	public function actionAdminDelete($id)
	{
		$this->loadModel($id)->delete();

		$this->actionAdminIndex(true);
	}

	public function actionAdminIndex($partial = false)
	{
		if( !$partial ){
			$this->layout = 'admin';
			$this->scripts[] = 'export';
		}
		$filter = new Export('filter');
		$criteria = new CDbCriteria();

		if (isset($_GET['Export']))
        {
            $filter->attributes = $_GET['Export'];
            foreach ($_GET['Export'] AS $key => $val)
            {
                if ($val != '')
                {
                    if( $key == "name" ){
                    	$criteria->addSearchCondition('name', $val);
                    }else{
                    	$criteria->addCondition("$key = '{$val}'");
                    }
                }
            }
        }

        $criteria->order = 'id DESC';

        $model = Export::model()->findAll($criteria);

		if( !$partial ){
			$this->render('adminIndex',array(
				'data'=>$model,
				'filter'=>$filter,
				'labels'=>Export::attributeLabels()
			));
		}else{
			$this->renderPartial('adminIndex',array(
				'data'=>$model,
				'filter'=>$filter,
				'labels'=>Export::attributeLabels()
			));
		}
	}

	public function loadModel($id)
	{
		$model=Export::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
