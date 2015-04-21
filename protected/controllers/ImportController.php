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
				'actions'=>array('adminIndex','adminStep2','adminStep3'),

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
		if(isset($_POST["GoodTypeId"]) && isset($_POST["excel_name"])) {
			// if( !$partial ){
			// $this->layout='admin';
			// }
			$model = GoodType::model()->findByPk($_POST["GoodTypeId"]);

			$folder = Yii::app()->params['tempFolder']."/".$_POST["excel_name"];

			$xls = $this->getXLS($folder,1);
			// if( !$partial ){
			// 	$this->render('adminStep2',array(
			// 	'model'=>$model
			// 	));
			// }else {
				$this->renderPartial('adminStep2',array(
				'model'=>$model,
				'xls'=>$xls,
				'folder'=>$folder
				));
			// }
		}
	}

	public function actionAdminStep3($partial = false)
	{
		if(isset($_POST["excel_folder"]) && isset($_POST["excel"])) {

			$model = GoodType::model()->findByPk($_POST["GoodTypeId"]);
			
			$xls = $this->getXLS($_POST["excel_folder"],$_POST["excel"]);

			foreach ($model->fields as $key => $value) {
            	$xls[0][$key] = $value->attribute->name;
            }
			print_r($xls);
			$this->renderPartial('adminStep3',array(
				'model'=>$model
				));
		}
	}

	public function loadModel($id)
	{
		$model=Import::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	private	function getXLS($xls,$var){
		include_once  Yii::app()->basePath.'/phpexcel/Classes/PHPExcel.php';
		include_once  Yii::app()->basePath.'/phpexcel/Classes/PHPExcel/IOFactory.php';
		
		$objPHPExcel = PHPExcel_IOFactory::load($xls);
		$objPHPExcel->setActiveSheetIndex(0);
		$aSheet = $objPHPExcel->getActiveSheet();
		
		$array = array();//этот массив будет содержать массивы содержащие в себе значения ячеек каждой строки
		//получим итератор строки и пройдемся по нему циклом
		foreach($aSheet->getRowIterator() as $row_nmb => $row){
			//получим итератор ячеек текущей строки
			$cellIterator = $row->getCellIterator();
			//пройдемся циклом по ячейкам строки
			$item = array();//этот массив будет содержать значения каждой отдельной строки
			foreach($cellIterator as $cell){
				//заносим значения ячеек одной строки в отдельный массив
				array_push($item, $cell->getCalculatedValue());
			}
			if(is_array($var)) {
				$tmp = array();
				foreach ($var as $i => $value) {
					if($value!="no-id") {
						array_push($tmp,$item[$i]);
					}
				}
				$item=$tmp;
			}
			if($var == 1) return $item;
			//заносим массив со значениями ячеек отдельной строки в "общий массив строк"
			array_push($array, $item);
			
		}
		return $array;
	} 


}
