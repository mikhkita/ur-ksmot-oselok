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
				'actions'=>array('adminIndex','adminFilter'),
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
		$criteria=new CDbCriteria();
   		$count=Good::model()->count($criteria);
   		$pages=new CPagination($count);

   		$pages->pageSize=1;
   		$pages->applyLimit($criteria);

		$model = Good::model()->findAll($criteria);
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
			$temp = array();
			foreach ($attr->variants as $variant) {
			array_push($temp,$variant->value);
			}
			$filter[$attr->name] = array();
			array_push($filter[$attr->name],$temp);
			array_push($filter[$attr->name],$attr->code);
		}
		$this->render('adminIndex',array(
			'goods'=>$goods,
			'filter' =>$filter,
			'pages' => $pages
         
		));
	}

	public function actionAdminFilter($partial = false)
	{
		if(isset($_POST)) {
			print_r($_POST);
		
			$this->render('adminFilter',array(
				'post'=>$_POST
			));
		}
	}
	
	public function loadModel($id)
	{
		$model=Good::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
