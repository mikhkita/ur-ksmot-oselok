<h1><?=$name?></h1>
<?php $form=$this->beginWidget('CActiveForm'); ?>
	<table class="b-table b-export-preview" border="1">
		<tr>
			<? foreach ($fields as $field): ?>
				<th<?if($field["VALUE"]->width>20):?> style="min-width:<?=$field["VALUE"]->width?>px;"<?endif;?>><?=$field["VALUE"]->name?></th>
			<? endforeach; ?>
		</tr>
		<? if( count($data->goods) ): ?>
			<? foreach ($data->goods as $i => $item): ?>
				<? $attr = $item->fields_assoc; ?>
				<tr>
					<? foreach ($fields as $field): ?>
						<td>
							<? if( $field["TYPE"] == "attr" ): ?>
								<? if( isset($attr[$field["VALUE"]->id]) ): ?>
									<div><p><?=$attr[$field["VALUE"]->id]->value?></p></div>
								<? endif; ?>
							<? else: ?>
								<div><p><?=Interpreter::generate($field["VALUE"]->id,$item)?></p></div>
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