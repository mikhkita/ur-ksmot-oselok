<h1>Страницы</h1>
<!-- <a href="<?php echo $this->createUrl('/page/admincreate')?>" class="ajax-form ajax-create b-butt b-top-butt">Добавить</a> -->
<?php $form=$this->beginWidget('CActiveForm'); ?>
	<table class="b-table" border="1">
		<tr>
			<th style="width: 30px;">№</th>
			<th><? echo $labels['pag_title']; ?></th>
			<th style="width: 145px;"><? echo $labels['pag_code']; ?></th>
			<th style="width: 150px;">Действия</th>
		</tr>
		<tr class="b-filter">
			<td></td>
			<td><?php echo CHtml::activeTextField($filter, 'pag_title'); ?></td>
			<td></td>
			<td><a href="#" class="b-clear-filter">Сбросить фильтр</a></td>
		</tr>
		<? if( count($data) ): ?>
			<? foreach ($data as $i => $item): ?>
				<tr>
					<td><? echo count($data)-$i; ?></td>
					<td class="align-left"><? echo $item->pag_title; ?></td>
					<td><? echo $item->pag_code; ?></td>
					<td><a href="<?php echo Yii::app()->createUrl('/page/adminupdate',array('id'=>$item->pag_id))?>" class="ajax-form ajax-update b-tool b-tool-update" title="Редактировать страницу"></a></td>
				</tr>
			<? endforeach; ?>
		<? else: ?>
			<tr>
				<td colspan=10>Пусто</td>
			</tr>
		<? endif; ?>
	</table>
<?php $this->endWidget(); ?>