<h1><?=$this->adminMenu["cur"]->name?></h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'import-step1',
	'action' => Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/adminstep_2'),
	'enableAjaxValidation'=>false)
); ?>

	<?php echo $form->errorSummary($model); ?>
	<ul>
	<? foreach ($model as $i => $item): ?>
		<li>
			<input type="radio" id="GoodType_<?=$item->id?>" name="GoodType[id]" value="<?=$item->id?>">
			<label for="GoodType_<?=$item->id?>"><?=$item->name?></label>
		</li>
	<? endforeach; ?>
	</ul>	
	<a href="#" data-path="<? echo Yii::app()->createUrl('/uploader/getForm',array('maxFiles'=>2,'extensions'=>'*', 'title' => 'Загрузка файла "Excel"', 'selector' => '.b-excel-input') ); ?>" class="b-get-image" >Добавить изображение</a>
	<input type="hidden" class="b-excel-input">
	<input type="submit" value="Далее" disabled>
<?php $this->endWidget(); ?>
</div>


