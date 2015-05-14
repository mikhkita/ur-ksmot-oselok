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
				'actions'=>array('adminIndex','adminFilter','adminDetail'),
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

	   		$pages->pageSize=10;
	   		$pages->applyLimit($criteria);
			// $criteria->select='id';  // выбираем только поле 'title'
			// $criteria->with = array('fields');
			// $posts=Good::model()->findAll($criteria);
			// // print_r($posts);
			$model = Good::model()->findAll($criteria);
			$goods = array();

			foreach ($model as $i => $good) {
				$temp = array();
				$temp['id'] = $good->id;
				foreach ($good->fields as $field) {
					$temp[$field->attribute->code] = $field->value;
				}
				array_push($goods,$temp);
			}
			$criteria=new CDbCriteria();
			$criteria->condition = 'list=1';
			$criteria->select = array('code','name');
			$criteria->with = array(
	            'variants'
	             => array(
	                'select' => array('int_value','varchar_value','float_value'),
	                'condition' => 'attribute_id=7 OR attribute_id=8 OR attribute_id=9 OR attribute_id=23  OR attribute_id=28  OR attribute_id=10  OR attribute_id=16  OR attribute_id=26  OR attribute_id=27'
	                )
	            );

			$model = Attribute::model()->findAll($criteria);
			$filter = array();
			foreach ($model as $attr) {
				$temp = array();
				foreach ($attr->variants as $i => $variant) {
					$temp[$i]['variant_id'] = $variant->id;
					$temp[$i]['value'] = $variant->value;
				}
				$filter[$attr->name] = $temp;			
			}
		if( !$partial ){
			$this->render('adminIndex',array(
				'goods'=>$goods,
				'filter' =>$filter,
				'pages' => $pages
			));
		}else{
			$this->renderPartial('_list',array(
				'goods'=>$goods,
				'pages' => $pages
			));
		}
	}

	public function actionAdminFilter($partial = false)
	{
		if($_GET) {
			print_r($_GET);
			$criteria=new CDbCriteria();
			$criteria->select = 'id';
			$criteria->group = 'fields.good_id';
			$criteria->order = 'fields.int_value ASC';
            $criteria->with = array('fields' => array('select'=> array('variant_id','attribute_id','int_value')));
            $count=0;
			foreach ($_GET as $name => $value) {		
				if( !($name=='price-min' || $name=='price-max' || $name=='partial' || $name=='page') ) {
					$condition .= 'fields.variant_id='.$value.' OR ';
					$count++;
				}
			}
			$criteria->condition = $condition.'(fields.attribute_id=20 AND fields.int_value>='.$_GET['price-min'].' AND fields.int_value<='.$_GET['price-max'].')';
        	$criteria->having = 'COUNT(fields.id)=2';
        	$model = Good::model()->findAll($criteria);
            $goods_id = array();
			foreach ($model as $good) {
				array_push($goods_id, $good->id); 
			}
		    $count=Good::model()->count($criteria);
		    

		    $criteria=new CDbCriteria();
		    $pages=new CPagination($count);
		    $pages->pageSize=10;
		    $pages->applyLimit($criteria);
		    $criteria->select = 'id';
		    $criteria->with = array(
		    	'fields' 
		    	=> array(
		    		'select'=> array('int_value','varchar_value','float_value','text_value','attribute_id','variant_id')
		    		)
		    );
		    $model=Good::model()->findAllbyPk($goods_id,$criteria);
			$goods = array();
			foreach ($model as $i => $good) {
				$temp = array();
				$temp['id'] = $good->id;
				$temp['TIRE_WIDTH'] = $good->fields_assoc[7]->value;
				$temp['TIRE_PROFILE'] = $good->fields_assoc[8]->value;
				$temp['DIAMETER'] = $good->fields_assoc[9]->value;
				$temp['SEASON'] = $good->fields_assoc[23]->value;
				$temp['WEAR'] = $good->fields_assoc[29]->value;
				$temp['AMOUNT'] = $good->fields_assoc[28]->value;
				$temp['TIRE_BRAND'] = $good->fields_assoc[16]->value;
				$temp['TIRE_MODEL'] = $good->fields_assoc[17]->value;
				$temp['COUNTRY'] = $good->fields_assoc[11]->value;
				$temp['CONDITION'] = $good->fields_assoc[26]->value;
				$temp['PRICE'] = $good->fields_assoc[20]->value;
				array_push($goods,$temp);
			} 

			if( !$partial ){
				$this->render('adminIndex',array(
					'goods'=>$goods,
					'filter' =>$filter,
					'pages' => $pages
				));
			}else{
				$this->renderPartial('_list',array(
					'goods'=>$goods,
					'pages' => $pages
				));
			}		
		}
	}
	
	public function actionAdminDetail($partial = false,$id)
	{
		if(isset($id)) {
			$model = Good::model()->findByPk($id);
			$good = array();
			foreach ($model->fields as $field) {
				$good[$field->attribute->code] = array();
				$good[$field->attribute->code]['NAME'] = $field->attribute->name;
				$good[$field->attribute->code]['VALUE'] = $field->value;
			}
			if( !$partial ){
				$this->render('adminDetail',array(
					'good'=>$good
				));
			}else{
				$this->renderPartial('adminDetail',array(
					'good'=>$good
				));
			}
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
