<?php

class YahooController extends Controller
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
				'actions'=>array('adminIndex'),
				'roles'=>array('manager'),
			),
			array('allow',
				'actions'=>array('index', 'detail','contacts'),
				'users'=>array('*'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionAdminIndex($countGood = false)
	{	
		$criteria=new CDbCriteria();
	   	$criteria->addCondition("state=0");
	   	$criteria->order = 'sort DESC';
		$dataProvider = new CActiveDataProvider('Yahoolot', array(
		    'criteria'=>$criteria,
		    'pagination'=>array(
		        'pageSize'=>20
		    )
		));
		$this->render('adminIndex',array(
			'model'=>$dataProvider->getData(),
			'pages' => $dataProvider->getPagination()
		));		
	}

	public function actionCount()
	{
		$goods=Good::model()->findAllbyPk($goods_id,$criteria);
	}

	public function loadModel($id)
	{
		$model=Good::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
