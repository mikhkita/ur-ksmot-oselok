<?php

class ShopController extends Controller
{
	public $layout='//layouts/shop';

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
				'actions'=>array('adminIndex'),
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
		
		$model = Good::model()->findAll();
		$goods = array();
		foreach ($model as $i => $good) {
			$temp = array();
			foreach ($good->fields as $fields) {
				$temp[$fields->attribute->code] = $fields->value;
			}
			array_push($goods,$temp);
		}
		$this->render('adminIndex',array(
			'goods'=>$goods
		));

	}
	
	public function loadModel($id)
	{
		$model=Good::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
