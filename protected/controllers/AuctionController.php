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
			$model->attributes=$_POST['Auction']+Injapan::getFields($_POST['Auction']['code'],$_POST['Auction']['price'])["main"];
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
			$prevState = $model->state;
			$prevCurrentPrice = $model->current_price;
			$model->attributes=$_POST['Auction']+Injapan::getFields($_POST['Auction']['code'],$_POST['Auction']['price'])["main"];
			if( $prevState == 2 && $model->current_price <= $prevCurrentPrice ) $model->state = 2;
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
		$yahon = new Yahon();

		// $model = Auction::model()->findAll(array("condition"=>"state=0 AND date<'".date("Y-m-d H:i:s", time()+$this->minutes_before*60)."'"));
		$model = Auction::model()->findAll(array("condition"=>"state=0 AND date<'".date("Y-m-d H:i:s", strtotime("2015-07-20 19:21:00")+$this->minutes_before*60)."'"));
		foreach ($model as $key => $auction) {
			$fields = NULL;
			$fields = Injapan::getFields($auction->code, $auction->price);

			if( intval($fields["main"]["state"]) == 0 ){ // ПОПРАВИТЬ НА 0
				// if( strtotime($fields["main"]["date"]) < time()+$this->minutes_before*60 ){
				if( strtotime($fields["main"]["date"]) < strtotime("2015-07-20 19:21:00")+$this->minutes_before*60 ){
					if( !$yahon->isAuth() ) $yahon->auth();

					$fields = $this->setBid($auction,$fields,$yahon);
				}
			}
			$auction->attributes = $fields["main"];
			$auction->save();
		}

		// $model = Auction::model()->findAll(array("condition"=>"state=2 AND date<'".date("Y-m-d H:i:s", time()+$this->minutes_before*60)."'"));
		$model = Auction::model()->findAll(array("condition"=>"state=2 AND date<'".date("Y-m-d H:i:s", strtotime("2015-07-20 19:21:00")+$this->minutes_before*60)."'"));
	}

	public function setBid($auction,$fields,$yahon){
		$tog = false;
		$counter = 0;
		do{
			$counter++;

			// Если 5 раз пробовали уже ставить ставку, то на 6-й раз ставим максимум
			$cur_price = ($counter == 1)?(intval($auction->price)-intval($fields["other"]["step"])):$fields["main"]["current_price"];
			
			$result = $yahon->setBid($auction->code,$cur_price,$fields["other"]["step"],$auction->price);
			Log::debug("Первый раз вернуло state=".$result["result"]."; cur_price = ".$cur_price);
			if( $result["result"] == 2 || $result["result"] == 0 ){
				$fields = Injapan::getFields($auction->code, $auction->price);

				Log::debug("Ставили: ".$result["price"]."; Сейчас: ".$fields["main"]["current_price"]);
				if( intval($fields["main"]["current_price"]) <= intval($result["price"]) ){
					$fields["main"]["state"] = 2;
					$tog = true;
				}else{
					$tog = ($counter == 1)?true:false;
				}
			}else{
				$fields["main"]["state"] = $result["result"];
				$tog = true;
			}
			Log::debug("Цикл завершился");
		}while(!$tog);

		return $fields;
	}

	public function loadModel($id)
	{
		$model=Auction::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
