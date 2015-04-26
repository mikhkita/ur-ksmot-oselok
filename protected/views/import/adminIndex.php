<h1><?=$this->adminMenu["cur"]->name?></h1>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'import-step1',
	'action' => Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/adminstep2'),
	'enableAjaxValidation'=>false
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<ul>
	<? foreach ($model as $i => $item): ?>
		<li>
			<input type="radio" id="GoodType-<?=$item->id?>" name="GoodTypeId" value="<?=$item->id?>">
			<label for="GoodType-<?=$item->id?>"><?=$item->name?></label>
		</li>
	<? endforeach; ?>
	</ul>	
	<a href="#" data-path="<? echo Yii::app()->createUrl('/uploader/getForm',array('maxFiles'=>1,'extensions'=>'*', 'title' => 'Загрузка файла "Excel"', 'selector' => '.b-excel-input') ); ?>" class="b-get-image" >Загрузить файл</a>
	<input type="hidden" name="excel_name" class="b-excel-input">
	<input type="submit" value="Далее">
<?php $this->endWidget(); ?>


