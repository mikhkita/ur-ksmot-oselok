<?php

class ArticleController extends Controller
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
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionAdminCreate()
	{
		$model=new Article;

		if(isset($_POST['Article']))
		{
			$model->attributes=$_POST['Article'];
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

		if(isset($_POST['Article']))
		{
			$model->attributes=$_POST['Article'];
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
		$filter = new Article('filter');
		$criteria = new CDbCriteria();

		if (isset($_GET['Article']))
        {
            $filter->attributes = $_GET['Article'];
            foreach ($_GET['Article'] AS $key => $val)
            {
                if ($val != '')
                {
                    if( $key == "art_title" ){
                    	$criteria->addSearchCondition('art_title', $val);
                    }else{
                    	$criteria->addCondition("$key = '{$val}'");
                    }
                }
            }
        }

        $model = Article::model()->findAll($criteria);

		if( !$partial ){
			$this->render('adminIndex',array(
				'data'=>$model,
				'filter'=>$filter,
				'labels'=>Article::attributeLabels()
			));
		}else{
			$this->renderPartial('adminIndex',array(
				'data'=>$model,
				'filter'=>$filter,
				'labels'=>Article::attributeLabels()
			));
		}
	}

	public function actionIndex($id){
		$this->scripts[] = 'blog';

		$model = Article::model()->findByPk($id);

		$data = Category::model()->with(array(
		    'articles'=>array(
		        'condition'=>'articles.art_hou_id = '.$model->art_hou_id,
		        'order'=>'articles.art_title ASC'
		    ),
		))->findAll(array(
		    'order'=>'cat_name ASC'
		));

		$this->render('index',array(
			'data'=>$data,
			'model'=>$model
		));
	}

	public function loadModel($id)
	{
		$model=Article::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
