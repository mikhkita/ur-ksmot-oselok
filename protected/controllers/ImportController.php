<?php

class ImportController extends Controller
{
	public $codeId = 3;

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
				'actions'=>array('adminIndex','adminStep2','adminStep3','adminImport'),
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
		$this->scripts[] = "import";

		if(isset($_POST["GoodTypeId"]) && isset($_POST["excel_name"])) {
			$model = GoodType::model()->findByPk($_POST["GoodTypeId"]);

			$excel_path = Yii::app()->params['tempFolder']."/".$_POST["excel_name"];

			$xls = $this->getXLS($excel_path,1);

			$this->render('adminStep2',array(
			'model'=>$model,
			'xls'=>$xls,
			'excel_path'=>$excel_path,
			'GoodTypeId'=>$_POST["GoodTypeId"]
			));
		}
	}

	public function actionAdminStep3($partial = false)
	{
		$this->scripts[] = "import";

		if(isset($_POST["excel_path"]) && isset($_POST["excel"]) && isset($_POST["GoodTypeId"])) {
			$model = GoodType::model()->findByPk($_POST["GoodTypeId"]);
			$sorted_titles = $_POST["excel"];// Массив соответствующих "ID атрибута" каждому столбцу
			$titles = array();
			$exist_codes = array();
			$arResult = array(
				"TITLES"=>NULL,
				"ROWS" => array(),
			);

			// Составление массива кодов элементов для проверки на наличие элемента из экселя в БД
			foreach ($model->goods as $key => $good) {
				foreach ($good->fields as $field) {
					if( $field->attribute->id == 3 ) $exist_codes[] = $field->value;
				}
			}

			// Получаем массив заголовков вида: array("ID атрибута" => "Наименование атрибута")
			foreach ($model->fields as $key => $value) {
            	$titles[intval($value->attribute->id)] = $value->attribute->name;
            }	

            // Получаем матрицу считанного экселя в отсортированном по столбцами виде
			$xls = $this->getXLS($_POST["excel_path"],$sorted_titles,$titles);

			$arResult["TITLES"] = $xls[0];

			for($i = 1; $i < count($xls); $i++) {
				$code = NULL;
				// Кладем в каждую ячейку матрицы массив данных об этой ячейке вида:
				// array("ID" => "ID атрибута", "VALUE" => "Значение этого атрибута из экселя", "HIGHLIGHT" => "Тип подсветки ячейки");
            	foreach ($xls[$i] as $j => $cell) {
            		$cellHighlight = NULL;
            		if( $cell == NULL ) $cellHighlight = "empty";

            		$xls[$i][$j] = array(
            			"ID" => $sorted_titles[$j],
            			"VALUE" => $cell,
            			"HIGHLIGHT" => $cellHighlight
            		);

            		// Ищем значение атрибута с наименованием "Код" для определения,
            		// существует ли уже элемент с данным кодом
            		if( intval($sorted_titles[$j]) == $this->codeId )
            			$code = $cell;
            	}

            	$arResult["ROWS"][] = array(
            		// Если уже есть элемент с таким кодом, то выделяем всю строку
					"HIGHLIGHT" => (in_array($code, $exist_codes))?"exist":NULL,
					"COLS" => $xls[$i]
				);
            }

			$this->render('adminStep3',array(
				'arResult'=>$arResult
			));
		}
	}

	public function actionAdminImport()
	{
		print_r($_POST["IMPORT"]);
		$this->render('adminImport',array(
			
		));
	}

	public function loadModel($id)
	{
		$model=Import::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	private	function getXLS($xls,$rows = false,$titles = false){
		if( is_array($rows) && $titles === false )
			throw new CHttpException(404,'Отсутствуют наименования столбцов');

		include_once  Yii::app()->basePath.'/phpexcel/Classes/PHPExcel.php';
		include_once  Yii::app()->basePath.'/phpexcel/Classes/PHPExcel/IOFactory.php';
		
		$objPHPExcel = PHPExcel_IOFactory::load($xls);
		$objPHPExcel->setActiveSheetIndex(0);
		$aSheet = $objPHPExcel->getActiveSheet();
		
		$array = array();
		$cols = 1;

		for ($i = 1; $i <= $aSheet->getHighestRow(); $i++) {  
		    $item = array();
		    for ($j = 0; $j < $cols; $j++) {
		        $val = $aSheet->getCellByColumnAndRow($j, $i)->getCalculatedValue()."";

	        	// Этот кусок кода ограничивает матрицу по столбцам смотря на первую строку.
				// Если в первой строке 3 ячейки заполенных, 
				// то и во всех остальных он будет смотреть только по первым трем ячейкам.
		        if( !($val === "" && $i == 1) && $j < $cols ){
					array_push($item, ($val === "")?NULL:$val );
					if( $i == 1 ) $cols++;
				}
		    }

		    // Если мы в переменной передаем массив отсортированных наименований столбцов
			// то происходит сортировка столбцов по этому массиву
			if(is_array($rows)) {
				$tmp = array();
				foreach ($rows as $key => $value) {
					if($value!="no-id") {
						if( $i == 1 ){
							array_push($tmp,$titles[intval($value)]);
						}else{
							array_push($tmp,$item[$key]);
						}
					}
				}
				$item=$tmp;
			}

			// Если нам нужна только первая строка
			if($rows === 1) return $item;

			array_push($array, $item);
		}
		return $array;
	} 


}
