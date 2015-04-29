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
			foreach ($good->fields as $field) {
				$temp[$field->attribute->code] = $field->value;
			}
			array_push($goods,$temp);
		}
		$model = Attribute::model()->findAll();
		$filter = array();
		foreach ($model as $attr) {
			$temp= array();
			foreach ($attr->variants as $variant) {
			array_push($temp,$variant->value);
			}
		$filter[$attr->name] = $temp;
		}
		$this->render('adminIndex',array(
			'goods'=>$goods,
			'filter' =>$filter
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
