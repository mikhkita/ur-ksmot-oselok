<?php

class AuctionController extends Controller
{
	public $minutes_before = 2;

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
			array('allow',
				'actions'=>array('adminCheck'),
				'users'=>array('*'),
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
			$model->attributes=$_POST['Auction']+$this->parseFields($_POST['Auction']['code'])["main"];
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
			$model->attributes=$_POST['Auction']+$this->parseFields($_POST['Auction']['code'])["main"];
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

	public function actionAdminCheck()
	{
		$model = Auction::model()->findAll(array("condition"=>"state=0 AND date<'".gmdate("Y-m-d H:i:s", time()+$this->minutes_before*60)."'"));
		foreach ($model as $key => $value) {
			echo $value->name."<br>";
		}
	}

	public function parseFields($code){
		include_once  Yii::app()->basePath.'/extensions/simple_html_dom.php';

		$result = array("main"=>array(),"other"=>array());

		$html = file_get_html("https://injapan.ru/auction/".$code.".html");

		// Получение заголовка лота
		$query = $html->find('.auction tr td[class=l]');
		$result["main"]["name"] = $query[0]->innertext;

		// Получение даты окончания аукциона
		$query = $html->find('#rowInfoEnddate td[class=l]');
		$arr = explode(" ",strip_tags($query[0]->innertext));
		$d = explode("/",$arr[0]);
		$result["main"]["date"] = $this->convertDate($d[2]."-".$d[1]."-".$d[0]." ".$arr[1].":00",3);

		// Получение первой фотографии
		$query = $html->find('.left_previews td img');
		$result["main"]["image"] = $query[0]->src;

		// Уточнение состояния аукциона. Завершен или не завершен
		$query = $html->find("#bidplace input[name=account]");
		$result["main"]["state"] = ( isset($query[0]) )?0:3;

		// Получение текущей цены лота
		$query = $html->find("#spanInfoPrice strong");
		$result["main"]["current_price"] = intval(str_replace("&nbsp;", "", strip_tags($query[0]->innertext)));

		// Получение шага ставки
		$query = $html->find("#spanInfoStep");
		$arr = explode("<span", $query[0]->innertext);
		$result["other"]["step"] = intval(preg_replace("/[^0-9]/", '', $arr[0] ));

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
