<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'faculties-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<? $multi_arr = array(); foreach ($model->fields as $item): ?>
		<div class="row">
			<? if($item->attribute->list): ?>
				<?  if($item->attribute->multi): ?>
					<? $selected = array(); foreach ($model->fields as $multi): ?>	
						<? if($item->attribute_id == $multi->attribute_id) $selected[$multi->variant->id] = array('selected' => 'selected'); ?>
					<? endforeach; ?>
						<?  if(!isset($multi_arr[$item->attribute_id])): ?>
							<label for="a-<?=$item->attribute_id?>"><?=$item->attribute->name?></label>
							<?php echo Chtml::dropDownList("Good_attr[".$item->id."]", $item->variant->id, CHtml::listData(AttributeVariant::model()->findAll(array("condition" => "attribute_id=".$item->attribute_id,"order" => "sort ASC")), 'id', $item->attribute->type->code.'_value'),array('class'=> 'select2','multiple' => 'true', 'options' => $selected)); ?>	
							<? $multi_arr[$item->attribute_id] = true; ?>
						<? endif; ?>
				<? else: ?>
					<label for="a-<?=$item->attribute_id?>"><?=$item->attribute->name?></label>
					<?php echo Chtml::dropDownList("Good_attr[".$item->id."][single]", $item->variant->id, CHtml::listData(AttributeVariant::model()->findAll(array("condition" => "attribute_id=".$item->attribute_id,"order" => "sort ASC")), 'id', $item->attribute->type->code.'_value'),array('class'=> 'select2')); ?>
				<? endif; ?>
			<? else:?>
				<label for="a-<?=$item->attribute_id?>"><?=$item->attribute->name?></label>
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