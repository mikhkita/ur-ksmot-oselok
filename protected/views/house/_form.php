<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'faculties-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'hou_name'); ?>
		<?php echo $form->textField($model,'hou_name',array('maxlength'=>255,'required'=>true)); ?>
		<?php echo $form->error($model,'hou_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hou_rub_id'); ?>
		<?php echo $form->dropDownList($model, 'hou_rub_id', CHtml::listData(Rubric::model()->findAll(), 'rub_id', 'rub_name')); ?>
		<?php echo $form->error($model,'hou_rub_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hou_typ_id'); ?>
		<?php echo $form->dropDownList($model, 'hou_typ_id', array( "1"=>"1", "2"=>"2", "3"=>"3" ) ); ?>
		<?php echo $form->error($model,'hou_typ_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
		<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->