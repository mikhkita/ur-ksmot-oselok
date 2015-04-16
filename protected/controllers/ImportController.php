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
				'actions'=>array('adminIndex', 'adminStep_2'),

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
	public function actionAdminStep_2()
	{
		require_once Yii::app()->basePath.'/../classes/PHPExcel.php'; // Подключаем библиотеку PHPExcel

	// 	$uploadDir = "upload/tmp";
	// 	$excelDir = "upload/excel";
	// 	print_r($_POST);
	// 	if(isset($_POST["Goodtype"])) {
	// 		$this->render('adminStep_2',array(
	// 		'model'=>"даров"
	// 		));
	// 	}

	// 	function getXLS($xls){
		// include_once Yii::app()->basePath.'/../classes/PHPExcel/IOFactory.php';
	// 	$objPHPExcel = PHPExcel_IOFactory::load($xls);
	// 	$objPHPExcel->setActiveSheetIndex(0);
	// 	$aSheet = $objPHPExcel->getActiveSheet();
		
	// 	$array = array();//этот массив будет содержать массивы содержащие в себе значения ячеек каждой строки
	// 	//получим итератор строки и пройдемся по нему циклом
	// 	foreach($aSheet->getRowIterator() as $row){
	// 		//получим итератор ячеек текущей строки
	// 		$cellIterator = $row->getCellIterator();
	// 		//пройдемся циклом по ячейкам строки
	// 		$item = array();//этот массив будет содержать значения каждой отдельной строки
	// 		foreach($cellIterator as $cell){
	// 			//заносим значения ячеек одной строки в отдельный массив
	// 			array_push($item, $cell->getCalculatedValue());
	// 		}
	// 		//заносим массив со значениями ячеек отдельной строки в "общий массв строк"
	// 		array_push($array, $item);
	// 	}
	// 	// unlink($xls);
	// 	return $array;
	
	// }
	// $xlsData = getXLS($uploadDir."/".$_POST["uploaderPj_0_tmpname"]);
	}
	public function loadModel($id)
	{
		$model=Import::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
