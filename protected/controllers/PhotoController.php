<?php

class PhotoController extends Controller
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

	public function actionAdminIndex($partial = false,$error = NULL)
	{
		if(isset($_POST['photo'])) {
			$files = array();
			foreach ($_POST['photo'] as $img) {
				$img_name = explode("/",$img);
				$img_name = array_pop($img_name);
				$img_code = explode(".",$img_name);
				// if(strripos($img_code[0],"_")) {
					$img_code = explode("_",$img_code[0]);
					$dir = Yii::app()->params["imageFolder"]."/"."tires/".$img_code[0];
					if (!is_dir($dir)) mkdir($dir,0777, true);
					copy( $img, $dir."/".$img_name);
				// }
				// else {
				// 	array_push($files,$img_name);
				// }
			}
			// if(count($files)) {
			// 	$error.= "Некорректное имя у ".implode(",", $files).", указанные файлы не были загружены";
			// }
			header('Location: '.$this->createUrl('/admin/photo'));
		}
		$this->render('adminIndex',array(
			'error' => $error
		));

		

		

	}
	
	public function loadModel($id)
	{
		$model=Import::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}




}
