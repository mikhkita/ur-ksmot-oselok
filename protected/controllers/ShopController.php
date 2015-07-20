<?php

class ShopController extends Controller
{
	public $layout='//layouts/shop';

	public $params = array(
		1 => array(
			"NAME" => "Шины",
			"TITLE_CODE" => 50,
			"TITLE_2_CODE" => 13,
			"DESCRIPTION_CODE" => 74,
			"GARANTY_CODE" => 77,
		),
		2 => array(
			"NAME" => "Диски",
			"TITLE_CODE" => 53,
			"TITLE_2_CODE" => 54,
			"DESCRIPTION_CODE" => 75,
			"GARANTY_CODE" => 78,
		));

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
				'actions'=>array('filter'),
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

	public function actionIndex($countGood = false)
	{	
		$criteria=new CDbCriteria();
        $criteria->condition = 'attribute_id=20';
        $criteria->select = array('int_value');
        $criteria->order = 'int_value ASC';
		$model = GoodAttribute::model()->findAll($criteria);
		$price_min = $model[0]->int_value;
		$price_max = array_pop($model)->int_value;

		$criteria=new CDbCriteria();
		$criteria->select = 'id';
		$criteria->group = 'fields.good_id';
		$criteria->order = 'fields.good_id DESC';
        $criteria->with = array('fields' => array('select'=> array('variant_id','attribute_id','int_value','varchar_value')));
        $count=0;
        $condition="";
        $check = array();
       	isset($_GET['price-min']) ? $_GET['price-min'] : $_GET['price-min'] = $price_min;
       	isset($_GET['price-max']) ? $_GET['price-max'] : $_GET['price-max'] = $price_max;
       	isset($_GET['Good_page']) ? $_GET['Good_page'] : $_GET['Good_page'] = 1;
       	isset($_GET['type']) ? $_GET['type'] : $_GET['type'] = 1;
       	$type = ($_GET['type']==1) ? "tires": "discs";
		foreach ($_GET as $name => $arr) {		
			if( !($name=='price-min' || $name=='price-max' || $name=='partial' || $name=='Good_page' || $name=='type' || $name=='countGood') ) {
				foreach ($arr as $value) {
				$check[$value] = true;
				$condition .= 'fields.variant_id='.$value.' OR ';
				}
				$count++;
			}
		}
		$criteria->condition = $condition.'(good_type_id='.$_GET['type'].' AND fields.attribute_id=20 AND fields.int_value>='.$_GET['price-min'].' AND fields.int_value<='.$_GET['price-max'].' )';
    	$criteria->having = 'COUNT(fields.id)='.($count+1);
    	$model=Good::model()->findAll($criteria);

        $goods_id = array();
		foreach ($model as $good) {
			array_push($goods_id, $good->id); 
		}

		$criteria=new CDbCriteria();
	   	$criteria->with = array('fields');
	   	$criteria->addInCondition("fields.good_id",$goods_id);
		$imgs = array_values(array_diff(scandir(Yii::app()->params["imageFolder"]."/".$type), array('..', '.', 'Thumbs.db','default-big.png','default.jpg')));
		$temp = "0";
		if(count($imgs)) {
			$temp = "";
			foreach ($imgs as $value) {
				$temp.="'".$value."',";
			}
			$temp = substr($temp, 0, -1);
			
		}
		$criteria->condition = 'good_type_id='.$_GET['type'].' AND (fields.attribute_id=3 AND fields.varchar_value IN('.$temp.')) ';
		$model=Good::model()->findAllbyPk($goods_id,$criteria);

		$goods_id = array();
		foreach ($model as $good) {
			array_push($goods_id, $good->id); 
		}

		$criteria=new CDbCriteria();
	   	$criteria->with = array('fields');
	   	$criteria->addInCondition("t.id",$goods_id);
		$dataProvider = new CActiveDataProvider('Good', array(
		    'criteria'=>$criteria,
		    'pagination'=>array(
		        'pageSize'=>13
		    )
		));
		$goods = $dataProvider->getData();
		$count = $dataProvider->getTotalItemCount();					
    	if( !$countGood ) {
    		
			$criteria=new CDbCriteria();
            $criteria->condition = 'list=1';
            $criteria->select = array('name');
            if($_GET['type']==1) {
            $criteria->with = array(
                'variants'
                 => array(
                    'select' => array('int_value','varchar_value','float_value'),
                    'condition' => 'attribute_id=7 OR attribute_id=8 OR attribute_id=9 OR attribute_id=23 OR attribute_id=16',
                    'order'=>'sort ASC'
                    )
                );
           	}
           	if($_GET['type']==2) {
            $criteria->with = array(
                'variants'
                 => array(
                    'select' => array('int_value','varchar_value','float_value'),
                    'condition' => 'attribute_id=6 OR attribute_id=9 OR attribute_id=5 OR attribute_id=31 OR attribute_id=32',
                    'order'=>'sort ASC'
                    )
                );
           	}
            $model = Attribute::model()->findAll($criteria); 
            $filter = array();
            foreach ($model as $attr) {
                $temp = array();

                foreach ($attr->variants as $i => $variant) {
                    $temp[$i]['variant_id'] = $variant->id;
                    $temp[$i]['value'] = $variant->value;
                    if(isset($check[$variant->id])) {
                    $temp[$i]['checked'] = "checked";
                	} else {
                		$temp[$i]['checked'] = "";
                	}
                }
                $filter[$attr->id] = $temp;           
            }					
		    
			$this->render('index',array(
				'goods'=>$goods,
				'filter' =>$filter,
				'price_min' => $price_min,
				'price_max' => $price_max,
				'pages' => $dataProvider->getPagination()
			));
		} else {
			echo $count;
		}		
	}

	public function actionDetail($partial = false,$id = NULL)
	{
		if($id) {

			$good=Good::model()->findbyPk($id);

			$imgs = $this->getImages($good);
			if( !$partial ){
				$this->render('detail',array(
					'good'=>$good,
					'imgs'=>$imgs
				));
			}else{
				$this->renderPartial('detail',array(
					'good'=>$good,
					'imgs'=>$imgs
				));
			}
		}
	}

	public function actionContacts()
	{
		$this->render('contacts');
	}

	public function actionCount()
	{
		$goods=Good::model()->findAllbyPk($goods_id,$criteria);
	}

	public function getImages($good, $number = NULL)
	{	
		$imgs = array();
		$path = Yii::app()->params["imageFolder"];
		$code = $good->fields_assoc[3]->value;
		if($good->good_type_id==1) $path .= "/tires/";
		if($good->good_type_id==2) $path .= "/discs/";
		$dir = $path.$code;
		if (is_dir($dir)) {
			$imgs = array_values(array_diff(scandir($dir), array('..', '.', 'Thumbs.db')));
			$dir = Yii::app()->request->baseUrl."/".$path.$code;
			if(count($imgs)) {
				if($number) {
					for ($i=0; $i < $number; $i++) { 
						$imgs[$i] = $dir."/".$imgs[$i];
					}
				} else {
					foreach ($imgs as $key => &$value) {
						$value = $dir."/".$value;
					}
				}			
			} else {
				array_push($imgs, Yii::app()->request->baseUrl."/".$path."default.jpg");
			}
		}
		else {
			array_push($imgs, Yii::app()->request->baseUrl."/".$path."default.jpg");	
		}
		return $imgs;
	}
	public function loadModel($id)
	{
		$model=Good::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
