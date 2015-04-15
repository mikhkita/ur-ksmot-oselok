<h1>Категории</h1>
<a href="<?php echo $this->createUrl('/category/admincreate')?>" class="ajax-form ajax-create b-butt b-top-butt">Добавить</a>
<?php $form=$this->beginWidget('CActiveForm'); ?>
	<table class="b-table" border="1">
		<tr>
			<th style="width: 30px;">№</th>
			<th><? echo $labels['name']; ?></th>
			<th style="width: 150px;">Действия</th>
		</tr>
		<tr class="b-filter">
			<td></td>
			<td><?php echo CHtml::activeTextField($filter, 'name'); ?></td>
			<td><a href="#" class="b-clear-filter">Сбросить фильтр</a></td>
		</tr>
		<? if( count($data) ): ?>
			<? foreach ($data as $i => $item): ?>
				<tr>
					<td><? echo count($data)-$i; ?></td>
					<td class="align-left"><a class="b-tooltip" title="Посмотреть все статьи этой категории" href="<?php echo Yii::app()->createUrl('/article/adminindex',array('Article[art_cat_id]'=>$item->id))?>"><? echo $item->name; ?></a></td>
					<td><a href="<?php echo Yii::app()->createUrl('/category/adminupdate',array('id'=>$item->id))?>" class="ajax-form ajax-update b-tool b-tool-update" title="Редактировать категорию"></a><a href="<?php echo Yii::app()->createUrl('/category/admindelete',array('id'=>$item->id))?>" class="ajax-form ajax-delete b-tool b-tool-delete" title="Удалить категорию"></a></td>
				</tr>
			<? endforeach; ?>
		<? else: ?>
			<tr>
				<td colspan=10>Пусто</td>
			</tr>
		<? endif; ?>
	</table>
<?php $this->endWidget(); ?>