<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'faculties-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'rub_name'); ?>
		<?php echo $form->textField($model,'rub_name',array('maxlength'=>255,'required'=>true)); ?>
		<?php echo $form->error($model,'rub_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rub_sort'); ?>
		<?php echo $form->numberField($model,'rub_sort',array('required'=>true,'type'=>'numeric','maxlength'=>10)); ?>
		<?php echo $form->error($model,'rub_sort'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rub_img'); ?>
		<div class="b-image-cancel">Отменить удаление</div>
		<div class="b-image-cont">
			<div data-path="<? echo Yii::app()->createUrl('/uploader/getForm'); ?>" class="b-input-image-add b-get-image<? if( $model->rub_img != "" ) echo " hidden"; ?>" title="Добавить изображение"></div>
			<div class="b-image-wrap<? if( $model->rub_img == "" ) echo " hidden"; ?>">
				<div class="b-input-image-img" data-base="<? echo (Yii::app()->request->baseUrl); ?>" data-path="<? echo Yii::app()->params['tempFolder']; ?>" style="background-image: url('<? echo (Yii::app()->request->baseUrl)."/".($model->rub_img); ?>');"></div>
				<?php echo $form->textField($model,'rub_img',array('class'=>'b-input-image','type'=>'numeric')); ?>
				<?php echo $form->error($model,'rub_img'); ?>
				<div class="b-image-controls clearfix">
					<div class="b-image-nav b-image-edit b-get-image" title="Изменить изображение"></div>
					<div class="b-image-nav b-image-delete" title="Удалить изображение"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
		<input type="button" onclick="$.fancybox.close(); return false;" value="Отменить">
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->