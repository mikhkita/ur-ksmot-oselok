<?php

class InterpreterController extends Controller
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
				'actions'=>array('adminIndex','adminCreate','adminUpdate','adminDelete','adminPreview'),
				'roles'=>array('manager'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionAdminCreate()
	{
		$model=new Interpreter;

		if(isset($_POST['Interpreter']))
		{
			$model->attributes=$_POST['Interpreter'];
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

		if(isset($_POST['Interpreter']))
		{
			$model->attributes=$_POST['Interpreter'];
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
		$filter = new Interpreter('filter');
		$criteria = new CDbCriteria();

		if (isset($_GET['Interpreter']))
        {
            $filter->attributes = $_GET['Interpreter'];
            foreach ($_GET['Interpreter'] AS $key => $val)
            {
                if ($val != '')
                {
                    $criteria->addSearchCondition($key, $val);
                }
            }
        }

        $criteria->order = 'id DESC';

        $model = Interpreter::model()->findAll($criteria);

		if( !$partial ){
			$this->render('adminIndex',array(
				'data'=>$model,
				'filter'=>$filter,
				'labels'=>Interpreter::attributeLabels()
			));
		}else{
			$this->renderPartial('adminIndex',array(
				'data'=>$model,
				'filter'=>$filter,
				'labels'=>Interpreter::attributeLabels()
			));
		}
	}

	public function actionAdminPreview($id)
	{
		$criteria = new CDbCriteria();
		$criteria->limit = 5;

        $model = Good::model()->findAll($criteria);
        $data = array();

        foreach ($model as $item) {
        	$data[] = array("ID"=>$item->fields_assoc[3]->value,"VALUE"=>$this->replaceToBr(Interpreter::generate($id,$item)));
        }

		$this->renderPartial('adminPreview',array(
			'data'=>$data,
		));
	}

	public function loadModel($id)
	{
		$model=Interpreter::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
