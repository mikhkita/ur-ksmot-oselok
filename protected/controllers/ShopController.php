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
                'select' => array('int_value','varchar_value','float_value')
                )
            );

		$model = Attribute::model()->findAll($criteria);
		// print_r($model);
		$filter = array();
		foreach ($model as $attr) {
			$temp = array();
			$temp['code'] = $attr->code;
			foreach ($attr->variants as $i => $variant) {
				$temp[$i+1]['id'] = $variant->id;
				$temp[$i+1]['value'] = $variant->value;
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
		if(isset($_POST)) {
			$criteria=new CDbCriteria();
			$criteria->select = 'id';
			$criteria->group = 'fields.good_id';
			$criteria->order = 'fields.int_value ASC';
            $criteria->with = array('fields' => array('select'=> array('variant_id','attribute_id','int_value')));

			foreach ($_POST as $attr) {
				if(is_array($attr)) {
					foreach ($attr as $value) {
						$condition .= 'fields.variant_id='.$value.' OR ';
						$count++;
					}
				}
			}
			$criteria->condition = $condition.'(fields.attribute_id=20 AND fields.int_value>='.$_POST['price-min'].' AND fields.int_value<='.$_POST['price-max'].')';
        	$criteria->having = 'COUNT(fields.id)='.$count+1;
        	$model = Good::model()->findAll($criteria);
            $goods_id = array();
			foreach ($model as $good) {
				array_push($goods_id, $good->id); 
			}
			
		    $count=Good::model()->count($criteria);
		    $pages=new CPagination($count);
		    $pages->pageSize=10;
		    $pages->applyLimit($criteria);

		    $criteria=new CDbCriteria();
		    $criteria->select = 'id';
		    $criteria->with = array(
		    	'fields' 
		    	=> array(
		    		'select'=> array('int_value','varchar_value','text_value','float_value','variant_id')
		    		),
		    	'fields.attribute'
		    	=> array(
		    		'select'=> array('code')
		    		)
		    );
		    $model=Good::model()->findAllbyPk($goods_id,$criteria);
			$goods = array();

			foreach ($model as $i => $good) {
			$temp = array();
			$temp['id'] = $good->id;
			foreach ($good->fields as $field) {
				$temp[$field->attribute->code] = $field->value;
			}
			array_push($goods,$temp);
			}
			print_r($model);
		    

            

			// $model = Good::model()->findAllbyPk($goods_id);
			// $criteria->select='id';  // выбираем только поле 'title'
			// $criteria->with = array('fields');
			// $posts=Good::model()->findAll($criteria);
			// // print_r($posts);
			// $model = Good::model()->findAll($criteria);
			print_r($pages->pageCount);
			$this->render('adminFilter',array(
				'post'=>$_POST
			));
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
