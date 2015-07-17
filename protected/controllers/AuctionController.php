<?php

class AuctionController extends Controller
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
				'actions'=>array('adminIndex','adminCreate','adminUpdate','adminDelete'),
				'roles'=>array('root'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionAdminCreate()
	{
		$model=new Auction;

		if(isset($_POST['Auction']))
		{
			$model->attributes=$_POST['Auction']+$this->parseFields($_POST['Auction']['code']);
			if($model->save()){
				$this->actionAdminIndex(true);
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

		if(isset($_POST['Auction']))
		{
			$model->attributes=$_POST['Auction']+$this->parseFields($_POST['Auction']['code']);
			if($model->save())
				$this->actionAdminIndex(true);
		}else{
			$this->renderPartial('adminUpdate',array(
				'model'=>$model,
			));
		}
	}

	public function actionAdminDelete($id)
	{
		$this->loadModel($id)->delete();

		$this->actionAdminIndex(true);
	}

	public function actionAdminIndex($partial = false)
	{
		if( !$partial ){
			$this->layout='admin';
		}
		$filter = new Auction('filter');
		$criteria = new CDbCriteria();

		if (isset($_GET['Auction']))
        {
            $filter->attributes = $_GET['Auction'];
            foreach ($_GET['Auction'] AS $key => $val)
            {
                if ($val != '')
                {
                    $criteria->addSearchCondition($key, $val);
                }
            }
        }

        $criteria->order = 'date ASC';

        $model = Auction::model()->findAll($criteria);

		if( !$partial ){
			$this->render('adminIndex',array(
				'data'=>$model,
				'filter'=>$filter,
				'labels'=>Auction::attributeLabels()
			));
		}else{
			$this->renderPartial('adminIndex',array(
				'data'=>$model,
				'filter'=>$filter,
				'labels'=>Auction::attributeLabels()
			));
		}
	}

	public function parseFields($code){
		include_once  Yii::app()->basePath.'/simple_html_dom.php';

		$result = array();

		$html = file_get_html("https://injapan.ru/auction/".$code.".html");

		$query = $html->find('.auction tr td[class=l]');

		$result["name"] = $query[0]->innertext;

		$query = $html->find('#rowInfoEnddate td[class=l]');

		$arr = explode(" ",strip_tags($query[0]->innertext));
		$d = explode("/",$arr[0]);
		$result["date"] = $d[2]."-".$d[1]."-".$d[0]." ".$arr[1].":00";

		$query = $html->find('.left_previews td img');

		$result["image"] = $query[0]->src;

		return $result;
	}

	public function loadModel($id)
	{
		$model=Auction::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
