<h1><?=$name?></h1>
<?php $form=$this->beginWidget('CActiveForm'); ?>
	<table class="b-table" border="1">
		<tr>
			<? foreach ($fields as $field): ?>
				<th><? echo $field->attribute->name; ?></th>
			<? endforeach; ?>
		</tr>
		<? if( count($data) ): ?>
			<? foreach ($data as $i => $item): ?>
				<tr>
					<? foreach ($fields as $field): ?>
						<td>
							<? if( isset($item[$field->attribute->id][0]) ): ?>
								<? foreach ($item[$field->attribute->id] as $attr): ?>
									<div><?=$attr->value?></div>
								<? endforeach; ?>
							<? endif; ?>
						</td>
					<? endforeach; ?>
				</tr>
			<? endforeach; ?>
		<? else: ?>
			<tr>
				<td colspan=10>Пусто</td>
			</tr>
		<? endif; ?>
	</table>
<?php $this->endWidget(); ?>