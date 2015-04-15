<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'usr_login'); ?>
		<?php echo $form->textField($model,'usr_login',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'usr_login'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'usr_password'); ?>
		<?php echo $form->passwordField($model,'usr_password',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'usr_password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'usr_name'); ?>
		<?php echo $form->textField($model,'usr_name',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'usr_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'usr_email'); ?>
		<?php echo $form->textField($model,'usr_email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'usr_email'); ?>
	</div>

	<div class="row">
		<?php 
			if( Yii::app()->user->checkAccess('createUser') ){
				echo $form->labelEx($model,'usr_role');
				$arr = array(
					User::ROLE_MANAGER=>User::ROLE_MANAGER,
					User::ROLE_ADMIN=>User::ROLE_ADMIN
				);
				echo $form->dropDownList($model,'usr_role',$arr);
				echo $form->error($model,'usr_role'); 
			}
		?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->