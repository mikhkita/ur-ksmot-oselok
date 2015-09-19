<h1><?=$name?></h1>
<?php $form=$this->beginWidget('CActiveForm'); ?>
	<table class="b-table" border="1">
		<tr>
			<th>&nbsp;</th>
			<? foreach ($fields as $field): ?>
				<th><? echo $field->attribute->name; ?></th>
			<? endforeach; ?>	
		</tr>
		<? if( count($data) ): ?>
			<? foreach ($data as $i => $item): ?>
				<tr>
					<td><a href="<?php echo Yii::app()->createUrl('/good/adminupdate',array('id'=>$item->id))?>" class="ajax-form ajax-update b-tool b-tool-update" title="Редактировать"></a></td>
					<? foreach ($fields as $field): ?>
						<td>
							<? if( isset($item->fields_assoc[$field->attribute->id]) ): ?>
								<? if( is_array($item->fields_assoc[$field->attribute->id]) ): ?>
									<? foreach ($item->fields_assoc[$field->attribute->id] as $attr): ?>
										<div><?=$attr->value?></div>
									<? endforeach; ?>
								<? else: ?>
									<div><?=$item->fields_assoc[$field->attribute->id]->value?></div>
								<? endif; ?>
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
<?php $this->widget('CLinkPager', array(
        'header' => '',
        'lastPageLabel' => 'последняя &raquo;',
        'firstPageLabel' => '&laquo; первая', 
        'pages' => $pages,
        'prevPageLabel' => '< назад',
        'nextPageLabel' => 'далее >'
    )) ?>