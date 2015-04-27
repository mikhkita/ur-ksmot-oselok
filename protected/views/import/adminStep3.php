<h1>Предпросмотр импорта</h1>	
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'import-step3',
	'action' => Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/adminimport'),
	'enableAjaxValidation'=>false
)); ?>
<table class="b-table" border="1">
	<tr>
		<? foreach ($arResult["TITLES"] as $i => $row): ?>
			<th><?=$row?></th>
		<? endforeach ?>
	</tr>

	<? foreach ($arResult["ROWS"] as $i => $row): ?>
		<tr<?if($row["HIGHLIGHT"] != NULL):?> class="b-<?=$row["HIGHLIGHT"]?>"<?endif;?>>
			<? foreach ($row["COLS"] as $j => $cell): ?>
				<td<?if($cell["HIGHLIGHT"] != NULL):?> class="b-<?=$cell["HIGHLIGHT"]?>"<?endif;?>>
					<? if($cell["VALUE"] != NULL): ?>
						<?=$cell["VALUE"]?>
						<input type="hidden" name="IMPORT[NEW][][<?=$cell["ID"]?>]" value="<?=$cell["VALUE"]?>">
					<? endif; ?>
				</td>
			<? endforeach ?>
		</tr>
	<? endforeach ?>
</table>
<?php echo CHtml::submitButton("Импортировать"); ?>
<?php $this->endWidget(); ?>