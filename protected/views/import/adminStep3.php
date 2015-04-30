<div class="b-import">
	<h1>Импорт</h1>
	<div class="progress">
	    <div class="progress-bar progress-bar-striped active" role="progressbar" style="width:3%">3%</div>
	</div>
	<div class="b-log"></div>
</div>
<div class="b-preview">
	<h1>Предпросмотр импорта</h1>	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'import-step3',
		'action' => Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/adminimport'),
		'enableAjaxValidation'=>false
	)); ?>
	<table class="b-table b-import-preview-table" border="1">
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
							<? foreach ($cell["VALUE"] as $g => $value): ?>
								<div>
									<?=$value?>
									<input type="hidden" name="IMPORT[ITEMS][][<?=$cell["ID"]?>]" value="<?=$value?>">
								</div>
							<? endforeach ?>	
						<? endif; ?>
						<? if(intval($cell["ID"]) == $this->codeId && isset($row["ID"])): ?>
							<input type="hidden" name="IMPORT[ID]" value="<?=$row["ID"]?>">
						<? endif; ?>
					</td>
				<? endforeach ?>
			</tr>
		<? endforeach ?>
	</table>
	<?php echo CHtml::submitButton("Импортировать"); ?>
	<?php $this->endWidget(); ?>
</div>