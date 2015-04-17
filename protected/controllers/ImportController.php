<?php

class ImportController extends Controller
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
				'actions'=>array('adminIndex', 'adminStep2'),

				'roles'=>array('manager'),
			),
			array('allow',
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionAdminIndex($partial = false)
	{
		$this->scripts[] = "import";
		$model = GoodType::model()->findAll();
		$this->render('adminIndex',array(
			'model'=>$model
		));

	}
	public function actionAdminStep2($partial = false)
	{
		if(isset($_POST["GoodTypeId"]) && isset($_POST["excel"])) {
			// if( !$partial ){
			// $this->layout='admin';
			// }
			include_once  Yii::app()->basePath.'/phpexcel/Classes/PHPExcel.php';
			include_once  Yii::app()->basePath.'/phpexcel/Classes/PHPExcel/IOFactory.php';
			$model = GoodType::model()->findByPk($_POST["GoodTypeId"]);
			foreach ($model->fields as $key => $value) {
				echo $value->attribute->name;
			}
			function getXLS($xls,$title){
				$objPHPExcel = PHPExcel_IOFactory::load($xls);
				$objPHPExcel->setActiveSheetIndex(0);
				$aSheet = $objPHPExcel->getActiveSheet();
				
				$array = array();//этот массив будет содержать массивы содержащие в себе значения ячеек каждой строки
				//получим итератор строки и пройдемся по нему циклом
				foreach($aSheet->getRowIterator() as $row){
					//получим итератор ячеек текущей строки
					$cellIterator = $row->getCellIterator();
					//пройдемся циклом по ячейкам строки
					$item = array();//этот массив будет содержать значения каждой отдельной строки
					
					foreach($cellIterator as $cell){
						//заносим значения ячеек одной строки в отдельный массив
						array_push($item, $cell->getCalculatedValue());
					}
					if($title) return $item;
					//заносим массив со значениями ячеек отдельной строки в "общий массв строк"
					array_push($array, $item);
					
				}
				return $array;
			} 	
			$xlsData = getXLS(Yii::app()->params['tempFolder']."/".$_POST["excel"],1);
			// if( !$partial ){
			// 	$this->render('adminStep2',array(
			// 	'model'=>$model
			// 	));
			// }else {
				$this->renderPartial('adminStep2',array(
				'model'=>$model
				));
			// }
		}
	}

	public function loadModel($id)
	{
		$model=Import::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
