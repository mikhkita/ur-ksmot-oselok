<div class="form" style="width: 712px;">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'faculties-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="b-full-width clearfix">
		<div class="row row-half">
			<?php echo $form->labelEx($model,'pag_title'); ?>
			<?php echo $form->textField($model,'pag_title',array('maxlength'=>255,'required'=>true)); ?>
			<?php echo $form->error($model,'pag_title'); ?>
		</div>

		<div class="row row-half">
			<?php echo $form->labelEx($model,'pag_code'); ?>
			<?php echo $form->textField($model,'pag_code',array('maxlength'=>30,'required'=>true)); ?>
			<?php echo $form->error($model,'pag_code'); ?>
		</div>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pag_text'); ?>
		<?php echo $form->textArea($model,'pag_text', array('id' => 'tinymce', 'style' => 'width:800px;height:500px;', 'required'=>true)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
		<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->