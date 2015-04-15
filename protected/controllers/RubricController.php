<?php

class RubricController extends Controller
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
				'actions'=>array('adminIndex','adminCreate','adminUpdate','adminDelete','adminView'),
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

	public function actionAdminCreate()
	{
		$model=new Rubric;

		if(isset($_POST['Rubric']))
		{
			$model->attributes=$_POST['Rubric'];

			if( $_POST['Rubric']['rub_img'] != "" ){
				$model->rub_img = $this->setImage($_POST['Rubric']['rub_img']);
			}

			if($model->save()){
				$this->actionAdminindex(true);
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

		if(isset($_POST['Rubric']))
		{
			$prevImg = $model->rub_img;
			$model->attributes=$_POST['Rubric'];

			if( $_POST['Rubric']['rub_img'] != $prevImg ){
				if(file_exists($prevImg)) unlink($prevImg);

				if( $_POST['Rubric']['rub_img'] != "" ){
					$model->rub_img = $this->setImage($_POST['Rubric']['rub_img']);
				}
			}

			if($model->save())
				$this->actionAdminindex(true);
		}else{
			$this->renderPartial('adminUpdate',array(
				'model'=>$model,
			));
		}
	}

	public function actionAdminView($id)
	{
		$this->layout='admin';

		$model=$this->loadModel($id);

		$this->render('adminView',array(
			'item'=>$model,
		));
	}

	public function setImage($name){
		$arr = explode("/", $name);
		$name = array_pop($arr);
		
		$tmpFileName = Yii::app()->params['tempFolder']."/".$name;
		$fileName = Yii::app()->params['imageFolder']."/".$name;

        $resizeObj = new Resize($tmpFileName);
        $resizeObj -> resizeImage(510, 380, 'crop');
        $resizeObj -> saveImage($fileName, 90);

        unlink($tmpFileName);
        return $fileName;
	}

	public function actionAdminDelete($id)
	{
		$this->loadModel($id)->delete();

		$this->actionAdminindex(true);
	}

	public function actionAdminIndex($partial = false)
	{
		if( !$partial ){
			$this->layout='admin';
		}

		$id = Yii::app()->user->id;
        $model = Rubric::model()->findAll();

		if( !$partial ){
			$this->render('adminIndex',array(
				'data'=>$model,
				'labels'=>Rubric::attributeLabels()
			));
		}else{
			$this->renderPartial('adminIndex',array(
				'data'=>$model,
				'labels'=>Rubric::attributeLabels()
			));
		}
	}

	public function actionIndex(){
		$model = Rubric::model()->findAll();

		$this->render('index',array(
			'data'=>$model
		));
	}

	public function loadModel($id)
	{
		$model=Rubric::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
