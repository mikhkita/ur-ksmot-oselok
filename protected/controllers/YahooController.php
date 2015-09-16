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
				'actions'=>array('adminIndex','adminDelete'),
				'roles'=>array('manager'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionAdminIndex($partial = false, $page = NULL)
	{	
		$page_size = 24;
		$criteria=new CDbCriteria();
	   	$criteria->addCondition("state=0");
	   	$criteria->order = 'sort DESC';
	   	$pagination = array('pageSize'=>$page_size,'route' => 'yahoo/adminindex');
	   	if($page!= NULL) {
	   		$pagination['currentPage'] = $page;
	   		unset($_GET['page']);
	   	}
		$dataProvider = new CActiveDataProvider('Yahoolot', array(
		    'criteria'=>$criteria,
		    'pagination'=>$pagination
		));
		$data = $dataProvider->getData();
		foreach ($data as &$item) {
			$item->title = preg_replace("/[^A-z0-9]/", " ", $item->title);
			// ("/[^A-z0-9]/", $item->title);
		}
		
		$options = array(
			'model'=>$dataProvider->getData(),
			'pages' => $dataProvider->getPagination()
		);
		if($partial) {
			$this->renderPartial('adminIndex',$options);		
		} else {
			$this->render('adminIndex',$options);
		}
	}

	public function actionAdminDelete($page = 0)
	{	
		$arr = json_decode($_POST['json']);
		$command = Yii::app()->db->createCommand();
		$temp = "";
		foreach ($arr as $value) {
			$temp.="'".$value."',";
		}
		$temp = substr($temp, 0, -1);
		$command->update('yahoo_lot', array(
		    'state'=>1,
		), 'id IN ('.$temp.')');
		$this->actionAdminIndex(true,$page);
			
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
