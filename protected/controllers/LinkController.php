<?php

class LinkController extends Controller
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
				'actions'=>array('adminIndex'),
				'roles'=>array('manager'),
			),
			array('allow',
				'actions'=>array(''),
				'users'=>array('*'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionAdminIndex()
	{
		$this->scripts[] = "link";
		if(isset($_POST['link'])) {
			include_once  Yii::app()->basePath.'/simple_html_dom.php';
			$html = new simple_html_dom();
			$html = file_get_html($_POST['link']); 
			$url = array_pop(explode("/",$_POST['link']));
			$url = str_replace(".html","",$url);
			$dir = Yii::app()->params["imageFolder"]."/links/".$url;
			if (!is_dir($dir)) mkdir($dir,0777, true);
			$imgs = array_values(array_diff(scandir($dir), array('..', '.', 'Thumbs.db')));
			if(!count($imgs)) {
				foreach ($html->find('div[class=old_lot_images] img') as $i => $item) { 
					copy( $item->src, $dir."/".$url."_".$i.".jpg");
	  			}
	  			$imgs = array_values(array_diff(scandir($dir), array('..', '.', 'Thumbs.db')));
	  			if(count($imgs)) {
	  				echo "1";
	  			}	else {
	  				echo "0";
	  			}
	  		} else {
	  			echo "2";
	  		}
		} else {
			$this->render('adminIndex');
		}
	}

}
