<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'faculties-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<? foreach ($model->fields as $key => $item): ?>
		<div class="row">
			<label for="a-<?=$item->attribute_id?>"><?=$item->attribute->name?></label>
			<? if($item->attribute->list): ?>
				<?php echo Chtml::dropDownList("a-".$item->attribute_id, $item->variant->id, CHtml::listData(AttributeVariant::model()->findAll(array("condition" => "attribute_id=".$item->attribute_id,"order" => "sort ASC")), 'id', $item->attribute->type->code.'_value')); ?>
			<? else:?>
				<?php echo Chtml::textField("a-".$item->attribute_id,$item->value,array('maxlength'=>255)); ?>
			<?endif;?>
		</div>
		
	<? endforeach; ?>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
		<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->