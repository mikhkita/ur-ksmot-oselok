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

			// Получаем массив заголовков вида: array("ID атрибута" => "Наименование атрибута")
			foreach ($model->fields as $key => $value) {
            	$titles[intval($value->attribute->id)] = array(
            		"NAME" => $value->attribute->name,
            		"TYPE" => $value->attribute->type->code,
            	);
            }	

            // Получаем матрицу считанного экселя в отсортированном по столбцами виде
			$xls = $this->getXLS($_POST["excel_path"],$sorted_titles,$titles);

			// Генерация структурированного ассоциативного массива для вью.
			$arResult = $this->getArResult($xls, $model->goods, $sorted_titles, $titles);

			// print_r($arResult);

			$this->render('adminStep3',array(
				'arResult'=>$arResult
			));
		}
	}

	public function getArResult($xls, $goods, $sorted_titles, $titles){
		$all_goods = array();
		$exist_codes = array();
		$arResult = array(
			"TITLES"=>NULL,
			"ROWS" => array(),
		);

		// Составление массива кодов элементов для проверки на наличие элемента из экселя в БД
		foreach ($goods as $key => $good) {
			$fields = array();
			$code = NULL;

			foreach ($good->fields as $field) {
				$fieldId = $field->attribute->id;
				if( !isset($fields[$fieldId]) ) $fields[$fieldId] = array();
				$fields[$fieldId][] = $field->value;

				if( $field->attribute->id == $this->codeId ) $code = $field->value;
			}
			$all_goods[$code] = $fields;
		}

		$arResult["TITLES"] = $xls[0];

		for($i = 1; $i < count($xls); $i++) {
			$code = $xls[$i][array_search($this->codeId, $sorted_titles)];
			$isset = isset($all_goods[$code]);

			// Кладем в каждую ячейку матрицы массив данных об этой ячейке вида:
			// array("ID" => "ID атрибута", "VALUE" => "Значение этого атрибута из экселя", "HIGHLIGHT" => "Тип подсветки ячейки");
        	foreach ($xls[$i] as $j => $cell) {
        		$id = $sorted_titles[$j]; // ID атрибута, в который будет вставляться значение
        		$field = ($isset)?( (isset($all_goods[$code][$id]))?($all_goods[$code][$id]):false ):false;
        		$cellValueAndHighlight = $this->getCellValueAndHighlight($cell,$titles[$id]["TYPE"],$field);

        		$xls[$i][$j] = array(
        			"ID" => $id,
        			"VALUE" => $cellValueAndHighlight["VALUE"],
        			"HIGHLIGHT" => $cellValueAndHighlight["HIGHLIGHT"]
        		);
        	}

        	$arResult["ROWS"][] = array(
        		// Если уже есть элемент с таким кодом, то выделяем всю строку
				"HIGHLIGHT" => ($isset)?"exist":NULL,
				"COLS" => $xls[$i]
			);
        }
        return $arResult;
	}

	public function getCellValueAndHighlight($value,$type,$fieldValues = false){
		$valid = false;
		$highlight = NULL;

		if( is_array($fieldValues) && $fieldValues[0] != $value ) $highlight = "overwrite";
		if( $value == NULL ){
			$highlight = "empty";
		}else{
			if( $type == "float" || $type == "int" ){
				if( is_numeric($value) ){
					$valid = true;
					if( $type == "int" ){
						$value = intval($value);
					}
				}
			}else $valid = true;

			if(!$valid) $highlight = "not-valid";
		}
		return array("VALUE" => $value, "HIGHLIGHT" => $highlight );
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
							array_push($tmp,$titles[intval($value)]["NAME"]);
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
