<?php
/* @var $this UserController */
/* @var $data User */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('usr_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->usr_id), array('view', 'id'=>$data->usr_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usr_login')); ?>:</b>
	<?php echo CHtml::encode($data->usr_login); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usr_email')); ?>:</b>
	<?php echo CHtml::encode($data->usr_email); ?>
	<br />


</div>