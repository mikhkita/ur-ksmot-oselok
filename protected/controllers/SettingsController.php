<?php

class SettingsController extends Controller
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
				'actions'=>array('adminIndex','adminCreate','adminUpdate','adminDelete','adminList',"adminCategoryCreate","adminCategoryUpdate"),
				'roles'=>array('manager'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionAdminCategoryCreate()
	{
		$model=new Category;

		if(isset($_POST['Category']))
		{
			$model->attributes=$_POST['Category'];
			if($model->save()){
				$this->actionAdminIndex(true);
				return true;
			}
		}

		$this->renderPartial('adminCategoryCreate',array(
			'model'=>$model,
		));

	}

	public function actionAdminCategoryUpdate($id)
	{
		$model=Category::model()->findByPk($id);

		if(isset($_POST['Category']))
		{
			$model->attributes=$_POST['Category'];
			if($model->save())
				$this->actionAdminIndex(true);
		}else{
			$this->renderPartial('adminCategoryUpdate',array(
				'model'=>$model,
			));
		}
	}

	public function actionAdminCreate()
	{
		$model=new Settings;

		if(isset($_POST['Settings']))
		{
			$model->attributes=$_POST['Settings'];
			if($model->save()){
				$this->actionAdminList($model->category_id,true);
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

		$this->checkAccess($model);

		if(isset($_POST['Settings']))
		{
			$model->attributes=$_POST['Settings'];
			if($model->save())
				$this->actionAdminList($model->category_id,true);
		}else{
			$this->renderPartial('adminUpdate',array(
				'model'=>$model,
			));
		}
	}

	public function actionAdminDelete($id)
	{
		$this->checkAccess( Settings::model()->findByPk($id) );

		$model = $this->loadModel($id);
		$model->delete();
		$cat_id = $model->category_id;

		$this->actionAdminList($cat_id,true);
	}

	public function actionAdminIndex($partial = false)
	{
		if( !$partial ){
			$this->layout='admin';
		}
  
		$model = Category::model()->findAll(array("order"=>'name ASC'));

		$option = array(
			'data'=>$model,
			'labels'=>Category::attributeLabels()
		);
		if( !$partial ){
			$this->render('adminIndex',$option);
		}else{
			$this->renderPartial('adminIndex',$option);
		}
	}

	public function actionAdminList($id,$partial = false)
	{
		if( !$partial ){
			$this->layout='admin';
		}

		$category = Category::model()->findByPk($id);

		$filter = new Settings('filter');
		$criteria = new CDbCriteria();

		if (isset($_GET['Settings']))
        {
            $filter->attributes = $_GET['Settings'];
            foreach ($_GET['Settings'] AS $key => $val)
            {
                if ($val != '')
                {
                    $criteria->addSearchCondition($key, $val);
                }
            }
        }

        $criteria->order = 'sort ASC';

        $criteria->addSearchCondition('category_id', $id);
  
		$model = Settings::model()->findAll($criteria);

		foreach ($model as $key => $item)
			if(!$this->checkAccess($item,true)) unset($model[$key]);

		$option = array(
			'data'=>$model,
			'filter'=>$filter,
			'category'=>$category,
			'labels'=>Settings::attributeLabels()
		);
		if( !$partial ){
			$this->render('adminList',$option);
		}else{
			$this->renderPartial('adminList',$option);
		}
	}

	public function loadModel($id)
	{
		$model=Settings::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
