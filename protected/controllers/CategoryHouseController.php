<?php

class CategoryHouseController extends Controller
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
				'actions'=>array('adminToggle'),
				'roles'=>array('manager'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionAdminToggle($one_name,$one_val,$two_name,$two_val)
	{
		$error = false;
		if( $_GET["action"] == "add" ){
			$exist = CategoryHouse::model()->exists($one_name.'=:one AND '.$two_name.'=:two',array(':one'=>$one_val,':two'=>$two_val));
			if( !$exist ){
				$model = new CategoryHouse;
				$model->attributes = array($one_name=>$one_val, $two_name=>$two_val);
				if( !$model->save() ){
					$error = "Ошибка при создании записи";
				}
			}
		}else if( $_GET["action"] == "del" ){
			if( !CategoryHouse::model()->deleteAll($one_name.'=:one AND '.$two_name.'=:two',array(':one'=>$one_val,':two'=>$two_val)) ){
				$error = "Ошибка при удалении записи";
			}
		}

		echo json_encode(array("error"=> $error ));
	}
}
