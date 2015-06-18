<h1>Выбор динамических параметров</h1>
<?php $form=$this->beginWidget('CActiveForm',array("action"=>$this->createUrl('/export/adminpreview',array('id'=>$id)))); ?>

<div class="b-choose-dynamic">
	<div class="clearfix">
	<? foreach ($data as $key => $value): ?>
		<div class="left b-dynamic">
			<p><label>Пример</label></p>
			<?php echo CHtml::dropDownList('dynamic['.$value->attribute->id.']', $value->attribute->variants[0]->id, CHtml::listData($value->attribute->variants, 'id', 'value')); ?>
			<input type="hidden" name="dynamic_values[<?=$value->attribute->id?>]" value="">
			<div class="b-error">Нужно выбрать хотя бы один параметр</div>
			<ul class="b-dynamic-values">
				<? foreach ($value->attribute->variants as $variant): ?>
					<li data-id="<?=$variant->id?>" class="selected"><?=$variant->value?></li>
				<? endforeach; ?>
			</ul>
		</div>
	<? endforeach; ?>
	</div>
</div>
<a href="#" onclick="$('form').submit(); return false;" class="b-butt">Далее</a>
<?php $this->endWidget(); ?>