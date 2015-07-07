<?php
$this->pageTitle=Yii::app()->name . ' - Ошибка';
$this->breadcrumbs=array(
	'Error',
);
?>
<h1>Ошибка</h1>

<h2>Error <?php echo $code; ?></h2>

<div class="error">
<?php echo Yii::app()->errorHandler->error["message"]; ?><br>
<?php echo Yii::app()->errorHandler->error["file"]."(".Yii::app()->errorHandler->error["line"].")"; ?>
</div>