<?php

class GoodController extends Controller
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
				'actions'=>array('adminIndex','adminCreate','adminUpdate','adminDelete','adminEdit'),
				'roles'=>array('manager'),
			),
			array('allow',
				'actions'=>array('adminIndex2'),
				'users'=>array('*'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionAdminCreate()
	{
		$model=new Good;

		if(isset($_POST['Good']))
		{
			$model->attributes=$_POST['Good'];
			if($model->save()){
				$this->actionAdminIndex(true);
				return true;
			}
		}

		$this->renderPartial('adminCreate',array(
			'model'=>$model,
		));

	}

	public function actionAdminUpdate($id)
	{
		$model=$this->loadModel($id);
		// print_r($model->fields[1]->value);
		if(isset($_POST['Good']))
		{
			$model->attributes=$_POST['Good'];
			if($model->save())
				$this->actionAdminIndex(true);
		}else{
			$this->renderPartial('adminUpdate',array(
				'model'=>$model,
			));
		}
	}

	public function actionAdminEdit($id)
	{
		$model=$this->loadModel($id);

		if( isset($_POST['Edit']) )
		{
			$this->updateVariants($model);
			$this->actionAdminIndex(true);
		}else{
			$this->renderPartial('adminEdit',array(
				'model'=>$model,
			));
		}
	}

	public function actionAdminDelete($id)
	{
		$this->loadModel($id)->delete();

		$this->actionAdminIndex(true);
	}

	public function actionAdminIndex($partial = false, $goodTypeId = false)
	{
		if( !$partial ){
			$this->layout='admin';
		}

		if( $goodTypeId ){

			$criteria = new CDbCriteria();
			$criteria->addCondition("good_type_id=".$goodTypeId);
			$dataProvider = new CActiveDataProvider('Good', array(
			    'criteria'=>$criteria,
			    'pagination'=>array(
			        'pageSize'=>25
			    )
			));
			$Goods = $dataProvider->getData();
			// $GoodType = GoodType::model()->with('goods.fields.variant','goods.fields.attribute')->findByPk($goodTypeId);
		}

		// $data = array();

		// foreach ($GoodType as $good) {
		// 	$item = array();
		// 	foreach ($good->fields as $field) {
		// 		if( isset($field->attribute) ){
		// 			$attrId = $field->attribute->id;
		// 			if( !isset($item[$attrId]) )
		// 				$item[$attrId] = array();
		// 			$item[$attrId][] = $field;
		// 		}
		// 	}
		// 	$data[$good->id] = $item;
		// }

		$options = array(
			'data'=>$Goods,
			'fields' => $Goods[0]->fields,
			'name'=>$Goods[0]->type->name,
			'pages' => $dataProvider->getPagination()
		);
		if( !$partial ){
			$this->render('adminIndex',$options);
		}else{
			$this->renderPartial('adminIndex',$options);
		}
	}

	public function actionAdminIndex2($goodTypeId = false){
		if( $goodTypeId ){
			$GoodType = GoodType::model()->with('goods.fields.variant','goods.fields.attribute')->findByPk($goodTypeId);
		}

		$this->render('index',array(
			'data'=>$GoodType->goods
		));
	}

	public function loadModel($id)
	{
		$model=Good::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function updateVariants($model){
		$tableName = GoodVariant::tableName();

		if( count($model->variants) ){
			$modelArr = array();
			foreach ($model->variants as $key => $value) {
				$modelArr[$value->id] = $value->sort;
			}


			if( isset($_POST["Variants"]) ){
				$delArr = array_diff_key($modelArr,$_POST["Variants"]);
			}else{
				$delArr = $modelArr;
			}
			$this->deleteVariants($delArr);

			if( isset($_POST["Variants"]) ){
				$tmpName = "tmp_".md5(rand().time());

				Yii::app()->db->createCommand()->createTable($tmpName, array(
				    'id' => 'int NOT NULL',
				    'int_value' => 'int NULL',
				    'varchar_value' => 'varchar(255) NULL',
				    'float_value' => 'float NULL',
				    'attribute_id' => 'int NULL',
				    'sort' => 'int NOT NULL',
				    0 => 'PRIMARY KEY (`id`)'
				), 'ENGINE=InnoDB');

				$sql = "INSERT INTO `$tmpName` (`id`,`attribute_id`,`sort`) VALUES ";

				$values = array();
				foreach ($_POST["Variants"] as $key => $value) {
					$values[] = "('".$key."','".$model->id."','".$value."')";
				}

				$sql .= implode(",", $values);

				if( Yii::app()->db->createCommand($sql)->execute() ){
					$sql = "INSERT INTO `$tableName` SELECT * FROM `$tmpName` ON DUPLICATE KEY UPDATE $tableName.sort = $tmpName.sort";
					$result = Yii::app()->db->createCommand($sql)->execute();
					
					Yii::app()->db->createCommand()->dropTable($tmpName);
				}
			}
		}	

		if( isset($_POST["VariantsNew"]) ){
			$sql = "INSERT INTO `$tableName` (`attribute_id`,`".$model->type->code."_value`,`sort`) VALUES ";

			$values = array();
			foreach ($_POST["VariantsNew"] as $key => $value) {
				$values[] = "('".$model->id."','".$key."','".$value."')";
			}

			$sql .= implode(",", $values);

			Yii::app()->db->createCommand($sql)->execute();
		}
	}

	public function deleteVariants($delArr){
		if( count($delArr) ){
			$pks = array();

			foreach ($delArr as $key => $value) {
				$pks[] = $key;
			}
			GoodVariant::model()->deleteByPk($pks);
		}
	}

	public function getArrayFromModel($model){

	}
}
