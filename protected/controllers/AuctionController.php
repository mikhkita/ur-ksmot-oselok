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
			$model->attributes=$_POST['Auction']+Injapan::getFields($_POST['Auction']['code'])["main"];
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
			$model->attributes=$_POST['Auction']+Injapan::getFields($_POST['Auction']['code'])["main"];
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
		// Log::setSniper("lololo");
		$model = Auction::model()->findAll(array("condition"=>"state=0 AND date<'".date("Y-m-d H:i:s", time()+$this->minutes_before*60)."'"));
		foreach ($model as $key => $auction) {
			$fields = NULL;
			$fields = Injapan::getFields($auction->code);

			if( intval($fields["main"]["state"]) == 30 ){ // ПОПРАВИТЬ НА 0
				if( strtotime($fields["main"]["date"]) < time()+$this->minutes_before*60 ){
					echo "string";
				}
			}
			// $auction->attributes = $fields["main"];
			// $auction->save();
		}
	}

	public function loadModel($id)
	{
		$model=Auction::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
