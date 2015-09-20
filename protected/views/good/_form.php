<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'faculties-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<? foreach $model->type->fields as $item): ?>
		<div class="row">
			<label><?=$item->attribute->name?></label>
			<? if($item->attribute->list): ?>
				<?  if($item->attribute->multi): ?>
					<? $selected = array(); foreach ($check[$item->attribute_id] as $multi): ?>	
						<? $selected[$multi] = array('selected' => 'selected'); ?>
					<? endforeach; ?>
						
						<?php echo Chtml::dropDownList("Good_attr[".$item->id."]", $item->variant->id, CHtml::listData(AttributeVariant::model()->findAll(array("condition" => "attribute_id=".$item->attribute_id,"order" => "sort ASC")), 'id', $item->attribute->type->code.'_value'),array('class'=> 'select2','multiple' => 'true',"empty" => "Выберите состояние", 'options' => $selected)); ?>	
				<? else: ?>
					<?php echo Chtml::dropDownList("Good_attr[".$item->id."]", "", CHtml::listData(AttributeVariant::model()->findAll(array("condition" => "attribute_id=".$item->attribute_id,"order" => "sort ASC")), 'id', $item->attribute->type->code.'_value'),array('class'=> 'select2',"empty" => "Выберите состояние")); ?>
				<? endif; ?>
			<? else:?>
				<?php echo Chtml::textField("Good_attr[".$item->id."]",$item->value,array('maxlength'=>255)); ?>
			<?endif;?>
		</div>
		
	<? endforeach; ?>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
		<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->