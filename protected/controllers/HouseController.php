<?php

class HouseController extends Controller
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
				'actions'=>array('adminIndex','adminCreate','adminUpdate','adminDelete','adminView'),
				'roles'=>array('manager'),
			),
			array('allow',
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionAdminCreate()
	{
		$model=new House;

		if(isset($_POST['House']))
		{
			$model->attributes=$_POST['House'];
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

		if(isset($_POST['House']))
		{
			$model->attributes=$_POST['House'];
			if($model->save())
				$this->actionAdminIndex(true);
		}else{
			$this->renderPartial('adminUpdate',array(
				'model'=>$model,
			));
		}
	}

	public function actionAdminView($id)
	{
		$this->layout='admin';

		$model=$this->loadModel($id);

		$this->render('adminView',array(
			'item'=>$model,
		));
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
		$filter = new House('filter');
		$criteria = new CDbCriteria();

		if (isset($_GET['House']))
        {
            $filter->attributes = $_GET['House'];
            foreach ($_GET['House'] AS $key => $val)
            {
                if ($val != '')
                {
                    if( $key == "hou_name" ){
                    	$criteria->addSearchCondition('hou_name', $val);
                    }else{
                    	$criteria->addCondition("$key = '{$val}'");
                    }
                }
            }
        }

        $model = House::model()->findAll($criteria);

		if( !$partial ){
			$this->render('adminIndex',array(
				'data'=>$model,
				'filter'=>$filter,
				'labels'=>House::attributeLabels()
			));
		}else{
			$this->renderPartial('adminIndex',array(
				'data'=>$model,
				'filter'=>$filter,
				'labels'=>House::attributeLabels()
			));
		}
	}

	public function actionIndex($id){
		$this->scripts[] = 'house';
		$this->scripts[] = 'slick';
		$model = Rubric::model()->findByPk($id);

		$this->render('index',array(
			'data'=>$model->houses,
			'title'=>$model->rub_name
		));
	}

	public function actionView($id){
		$this->scripts[] = 'room';

		$model = Category::model()->with(array(
		    'articles'=>array(
		        'condition'=>'articles.art_hou_id = '.$id,
		    ),
		))->findAll(array(
		    'order'=>'cat_name ASC'
		));
		// $model = Category::model()->with('category')->findAll(array(
		//     'order'=>'category.cat_name',
		//     'condition'=>'art_hou_id = '.$id
		// ));

		// $arr = array();

		// foreach ($model as $i => $article) {
		// 	if(  )
		// 	$arr[$article->category->cat_name][] = $article;
		// }

		$this->render('view',array(
			'data'=>$model
		));
	}

	public function loadModel($id)
	{
		$model=House::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
