<?php
	require_once 'Classes/PHPExcel.php'; // Подключаем библиотеку PHPExcel

	$uploadDir = "upload/tmp";
	$excelDir = "upload/excel";

	function WriteExcel($data){
		global $excelDir;

		$phpexcel = new PHPExcel(); // Создаём объект PHPExcel
		$filename = "example.xlsx";

		/* Каждый раз делаем активной 1-ю страницу и получаем её, потом записываем в неё данные */
		$page = $phpexcel->setActiveSheetIndex(0); // Делаем активной первую страницу и получаем её
		foreach($data as $i => $ar){ // читаем массив
			foreach($ar as $j => $val){
				$page->setCellValueByColumnAndRow($j,$i+1,$val); // записываем данные массива в ячейку
				$page->getStyleByColumnAndRow($j,$i+1)->getAlignment()->setWrapText(true);
			}
		}
		$page->setTitle("Фотодоска"); // Заголовок делаем "Example"
		$page->getColumnDimension('C')->setWidth(80);
		/* Начинаем готовиться к записи информации в xlsx-файл */
		$objWriter = PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
		/* Записываем в файл */
		$objWriter->save($excelDir."/".$filename);

		return $excelDir."/".$filename;
	}

	function DownloadFile($source,$filename) {
	  if (file_exists($source)) {
	    
	    if (ob_get_level()) {
	      ob_end_clean();
	    }

	    $arr = explode(".", $source);
	    
	    header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename='.$filename.".".array_pop($arr) );
	    header('Content-Transfer-Encoding: binary');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($source));
	    
	    readfile($source);
	    exit;
	  }
	}

	function getXLS($xls){
		include_once 'Classes/PHPExcel/IOFactory.php';
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
			//заносим массив со значениями ячеек отдельной строки в "общий массв строк"
			array_push($array, $item);
		}
		// unlink($xls);
		return $array;
	}

	function cmp($a, $b){
		$a = $a[3];
		$b = $b[3];
	    if ($a == $b) {
	        return 0;
	    }
	    return ($a < $b) ? -1 : 1;
	}
	
	$xlsData = getXLS($uploadDir."/".$_POST["uploaderPj_0_tmpname"]); //извлеаем данные из XLS

	$out = array();

	usort($xlsData, "cmp");

	for( $i = 1 ; $i < count($xlsData) ; $i++ ){
		$row = $xlsData[$i];
		
		if( !isset($out[$row[4]]) ){
			$out[$row[4]] = array(array("maxPrice"=>0,"maxId"=>0,"minPrice"=>999999),array());
		}

		if( $out[$row[4]][0]["maxPrice"] < intval($row[3]) ){
			$out[$row[4]][0]["maxPrice"] = intval($row[3]);
			$out[$row[4]][0]["maxId"] = $row[0];
		}

		if( $out[$row[4]][0]["minPrice"] > intval($row[3]) ){
			$out[$row[4]][0]["minPrice"] = intval($row[3]);
		}

		$text = "#".$row[0]." ".$row[1]." ".$row[4];
		// $text = "#".$row[0]." ".$row[1]." ".$row[4];
		$price = " износ ".round($row[2])."% ".$row[5]."шт. ".$row[3]." руб.";
		if( isset($row[6]) && $row[6] != "" ){
			$text = "<a href=".$row[6]." target='_blank'>".$text."</a>".$price;
		}else{
			$text .= $price;
		}

		array_push($out[$row[4]][1],$text);
	}

	$excel = array(array("№","Заголовок","Текст","Цена","Тип","Проверка"));

	foreach ($out as $j => $ar) {
		$id = $ar[0]["maxId"];
		$title = $j;
		$text = $_POST["header"]."\r\n".implode("\r\n", $ar[1])."\r\n".$_POST["footer"];
		$price = $ar[0]["minPrice"];
		$type = 1;
		$excel[] = array($id,$title,$text,$price,$type,1);
	}

	// print_r($excel);
	
	$file = WriteExcel($excel);

	DownloadFile($file,"PhotoDoska");
?>	
