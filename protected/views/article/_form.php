<div class="form" style="width: 712px;">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'faculties-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="b-full-width">
		<div class="row">
			<?php echo $form->labelEx($model,'art_title'); ?>
			<?php echo $form->textField($model,'art_title',array('maxlength'=>255,'required'=>true)); ?>
			<?php echo $form->error($model,'art_title'); ?>
		</div>
	</div>

	<div class="b-full-width clearfix">
		<div class="row row-half">
			<?php echo $form->labelEx($model,'art_hou_id'); ?>
			<?php echo $form->textField($model, 'art_hou_id', array('class'=>'autocomplete categories','required'=>'required','data-label'=>($model->house && $model->house->hou_name)?$model->house->hou_name:'Выбрать дом','data-values'=>$this->getRubricsWithHouses() )); ?>
			<?php echo $form->error($model,'art_hou_id'); ?>
		</div>

		<div class="row row-half">
			<?php echo $form->labelEx($model,'art_cat_id'); ?>
			<?php echo $form->textField($model, 'art_cat_id', array('class'=>'autocomplete','required'=>'required','data-label'=>($model->category && $model->category->cat_name)?$model->category->cat_name:'Выбрать категорию','data-values'=>$this->getCategories() )); ?>
			<?php echo $form->error($model,'art_cat_id'); ?>
		</div>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'art_text'); ?>
		<?php echo $form->textArea($model,'art_text', array('id' => 'tinymce', 'style' => 'width:960px;height:500px;', 'required'=>true)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
		<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->