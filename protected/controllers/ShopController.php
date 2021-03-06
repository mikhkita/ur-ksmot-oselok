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
			"PRICE_CODE" => 95,
			"ORDER" => 120
		),
		2 => array(
			"NAME" => "Диски",
			"TITLE_CODE" => 53,
			"TITLE_2_CODE" => 54,
			"DESCRIPTION_CODE" => 75,
			"GARANTY_CODE" => 78,
			"PRICE_CODE" => 94,
			"ORDER" => 121
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
				'actions'=>array('index', 'detail','contacts','mail'),
				'users'=>array('*'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex($countGood = false)
	{	
		$count=0;
        $condition="";
        $check = array();
        
       	isset($_GET['type']) ? $_GET['type'] : $_GET['type'] = 1;
		$type = ($_GET['type']==1) ? "tires": "discs";

		$criteria=new CDbCriteria();
		$criteria->with = array('good' => array('select'=> false));
        $criteria->condition = 'attribute_id=20 AND good.good_type_id='.$_GET['type'];
        $criteria->select = array('int_value');
        $criteria->order = 'int_value ASC';

		$model = GoodAttribute::model()->findAll($criteria);
		$price_min = $model[0]->int_value;
		$price_max = array_pop($model)->int_value;
		
		$imgs = array_values(array_diff(scandir(Yii::app()->params["imageFolder"]."/".$type), array('..', '.', 'Thumbs.db','default-big.png','default.jpg')));
		$temp = "0";
		if(count($imgs)) {
			$temp = "";
			foreach ($imgs as $value) {
				$temp.="'".$value."',";
			}
			$temp = substr($temp, 0, -1);
			
		}

		$criteria=new CDbCriteria();
		$criteria->select = 'id,good_type_id';
	   	$criteria->with = array('fields' => array('select'=> array('attribute_id','varchar_value')));
		$criteria->condition = 'good_type_id='.$_GET['type'].' AND (fields.attribute_id=3 AND fields.varchar_value IN('.$temp.'))';

		$model=Good::model()->findAll($criteria);

		$goods_no_photo = array();
		foreach ($model as $good) {
			array_push($goods_no_photo, $good->id); 
		}

		isset($_GET['Good_page']) ? $_GET['Good_page'] : $_GET['Good_page'] = 1;
		isset($_GET['price-min']) ? $_GET['price-min'] : $_GET['price-min'] = $price_min;
       	isset($_GET['price-max']) ? $_GET['price-max'] : $_GET['price-max'] = $price_max;

		$criteria=new CDbCriteria();
		$criteria->select = 'id';
		$criteria->group = 'fields.good_id';
		
        $criteria->with = array('fields' => array('select'=> array('variant_id','attribute_id','int_value')));
        // $criteria->addInCondition("id",$goods_no_photo);

        $criteria->condition = '(good_type_id='.$_GET['type'].' AND fields.attribute_id=20 AND fields.int_value>='.$_GET['price-min'].' AND fields.int_value<='.$_GET['price-max'].' )';
        if(isset($_GET['arr']))
		foreach ($_GET['arr'] as $id => $arr) {		
			foreach ($arr as $value) {
				$check[$value] = true;
				$criteria->addCondition('fields.variant_id='.$value,'OR');
				
			}
			$count++;
		}

    	$criteria->having = 'COUNT(fields.id)>='.($count+1);
    	$model=Good::model()->findAllbyPk($goods_no_photo,$criteria);
        $goods_id = array();
		foreach ($model as $good) {
			array_push($goods_id, $good->id); 
		}

		
		if( (isset($_GET['arr'][5]) && (count($_GET['arr'][5]) > 1)) || 
			(isset($_GET['arr'][31]) && (count($_GET['arr'][31]) > 1)) ||
			(isset($_GET['arr'][32]) && (count($_GET['arr'][32]) > 1))
			) {
			$model=Good::model()->findAllbyPk($goods_id);
			foreach ($model as $key => $good) {
				$count = array();
				foreach ($good->fields as $attr) {
					foreach ($check as $value => $item) {
						if($attr->variant_id == $value) $count[$attr->attribute_id] = true;
						
					}			
				}
				if(count($count) < count($_GET['arr']))  {
					unset($model[$key]);
				}
			}
			$goods_id = array();
			foreach ($model as $good) {
				array_push($goods_id, $good->id); 
			}
		}
		$sort = (isset($_GET['sort']['id'])) ? $_GET['sort'] : NULL;
		$goods = $this->sort($goods_id,$sort);

		$count = $goods['count'];	
		$pages = $goods['pages'];	
		$goods = $goods['model'];

    	if( !$countGood ) {
    		
			// $criteria=new CDbCriteria();
   //          $criteria->condition = 'list=1';
   //          $criteria->select = array('id');
   //          if($_GET['type']==1) {
   //          $criteria->with = array(
   //              'variants'
   //               => array(
   //                  'select' => array('int_value','varchar_value','float_value'),
   //                  'condition' => 'attribute_id=7 OR attribute_id=8 OR attribute_id=9 OR attribute_id=23 OR attribute_id=16 OR attribute_id=27'
   //                  )
   //              );
   //         	}
   //         	if($_GET['type']==2) {
   //          $criteria->with = array(
   //              'variants'
   //               => array(
   //                  'select' => array('int_value','varchar_value','float_value'),
   //                  'condition' => 'attribute_id=6 OR attribute_id=9 OR attribute_id=5 OR attribute_id=31 OR attribute_id=32 OR attribute_id=27'
   //                  )

   //              );
   //         	}
            // $model = Attribute::model()->findAll($criteria);
            // foreach ($model as $attr) { 
            //     $temp = array();
            //     foreach ($attr->variants as $i => $variant) {
	           //          $temp[$i]['variant_id'] = $variant->id;
	           //          $temp[$i]['value'] = $variant->value;
	           //          if(isset($check[$variant->id])) {
	           //          $temp[$i]['checked'] = "checked";
	           //      	} else {
	           //      		$temp[$i]['checked'] = "";
	           //      	}	           
            //     }
            //     $filter[$attr->id] = $temp;           
            // }	

            $criteria=new CDbCriteria();
            $criteria->with = array(
                'good'
                 => array(
                    'select' => false,
                    'condition' => 'good_type_id='.$_GET['type']
                    ),
                'variant' => array(
                		'select' => false
                	)

                );
            $criteria->condition = 't.attribute_id=9 OR t.attribute_id=27 OR t.attribute_id=28 OR ';
            if($_GET['type']==1) {
            	$criteria->condition .= 't.attribute_id=7 OR t.attribute_id=8 OR t.attribute_id=23 OR t.attribute_id=16';
        	}	
        	if($_GET['type']==2) {
            	$criteria->condition .= 't.attribute_id=6 OR t.attribute_id=5 OR t.attribute_id=31 OR t.attribute_id=32';
        	}	

        	$criteria->addInCondition("good.id",$goods_no_photo);
            $criteria->group = 't.variant_id';
            $criteria->order = 'variant.sort ASC';

            $model = GoodAttribute::model()->findAll($criteria);
            $filter = array();

   			foreach ($model as $i => $item) {
   				if(!isset($filter[$item->attribute_id])) {
   					$filter[$item->attribute_id] = array();
   					$temp = array();
   				}
   				$temp['variant_id'] = $item->variant_id;
	                    $temp['value'] = $item->value;
	                    if(isset($check[$item->variant_id])) {
	                    $temp['checked'] = "checked";
	                	} else {
	                		$temp['checked'] = "";
	                	}
   				array_push($filter[$item->attribute_id], $temp);
   			}
			$this->render('index',array(
				'goods'=>$goods,
				'filter' =>$filter,
				'price_min' => $price_min,
				'price_max' => $price_max,
				'pages' => $pages
			));
		} else {
			echo $count;
		}		
	}

	public function sort($goods_id,$attr = NULL) {
		$criteria=new CDbCriteria();	
		$criteria->order = 't.id DESC';
		if($attr) {
			$criteria->with = ($attr['id'] != 20) ? array('fields' => array('select'=> array('attribute_id')),"fields.variant"=> array('select' => array('sort'))) : array('fields' => array('select'=> array('variant_id','attribute_id','int_value')));
			$criteria->together = true;
			$criteria->group = 'fields.good_id';
			$sort = $attr['sort_type'];
	        $criteria->condition = 'fields.attribute_id='.$attr['id'];
	        $criteria->order = ($attr['id'] != 20) ? 'variant.sort '.$sort : 'fields.int_value '.$sort;
	    }
	    $criteria->addInCondition("t.id",$goods_id);
		$dataProvider = new CActiveDataProvider('Good', array(
		    'criteria'=>$criteria,
		    'pagination'=>array(
		        'pageSize'=>13
		    )
		));
		$goods = $dataProvider->getData();
		if($attr) {
			$goods_id = array();
			foreach ($goods as $good) {
				array_push($goods_id, $good->id); 
			}
			$goods = Good::model()->findAllbyPk($goods_id);
			usort($goods, function($a, $b) use($attr) {
				$a = (is_array($a->fields_assoc[$attr['id']])) ? $a->fields_assoc[$attr['id']][0]->value : $a->fields_assoc[$attr['id']]->value;
				$b = (is_array($b->fields_assoc[$attr['id']])) ? $b->fields_assoc[$attr['id']][0]->value : $b->fields_assoc[$attr['id']]->value;
			    if ($a == $b) {
			        return 0;
			    }
			    if($attr['sort_type'] == "DESC") return ($a > $b) ? -1 : 1; else return ($a < $b) ? -1 : 1;
			});

		}
		return array('model' => $goods,'count' => $dataProvider->getTotalItemCount(), 'pages' => $dataProvider->getPagination());
	}

	public function actionDetail($partial = false,$id = NULL)
	{
		if($id) {
			$good = Good::model()->with("fields")->find("good_type_id=".$_GET['type']." AND fields.attribute_id=3 AND fields.varchar_value='".$id."'");
			$good = Good::model()->findByPk($good->id);

			$this->title = Interpreter::generate($this->params[$_GET['type']]["TITLE_CODE"], $good);

			$this->description = $this->keywords = Interpreter::generate($this->params[$_GET['type']]["DESCRIPTION_CODE"], $good);

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

	public function loadModel($id)
	{
		$model=Good::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function actionMail(){
        require_once("phpmail.php");

        $email_admin = $this->getParam("SHOP","EMAILS");

        $from = "Koleso Tomsk Ru";
        $email_from = "koleso@tomsk.ru";

        $deafult = array("name"=>"Имя","phone"=>"Телефон", "email"=>"E-mail");

        $fields = array();

        if( count($_POST) ){

            foreach ($deafult  as $key => $value){
                if( isset($_POST[$key]) ){
                    $fields[$value] = $_POST[$key];
                }
            }

            $i = 1;
            while( isset($_POST[''.$i]) ){
                $fields[$_POST[$i."-name"]] = $_POST[''.$i];
                $i++;
            }

            $subject = $_POST["subject"];

            foreach ($fields  as $key => $value){
                $message .= "<div><p><b>".$key.": </b>".$value."</p></div>";
            }

            $message .= "<div><p><b>Товар: </b><a target='_blank' href='".$_POST["good-url"]."'>".$_POST["good"]."</a></p></div>";
                
            $message .= "</div>";
            
            if(send_mime_mail("Сайт ".$from,$email_from,$name,$email_admin,'UTF-8','UTF-8',$subject,$message,true)){    
                echo "1";
            }else{
                echo "0";
            }
        }
    }
}
