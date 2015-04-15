<h1>Дома</h1>
<a href="<?php echo $this->createUrl('/house/admincreate')?>" class="ajax-form ajax-create b-butt b-top-butt">Добавить</a>
<?php $form=$this->beginWidget('CActiveForm'); ?>
	<table class="b-table" border="1">
		<tr>
			<th style="width: 30px;">№</th>
			<th><? echo $labels['hou_name']; ?></th>
			<th style="width: 145px;"><? echo $labels['hou_rub_id']; ?></th>
			<th style="width: 135px;"><? echo $labels['hou_typ_id']; ?></th>
			<th style="width: 150px;">Действия</th>
		</tr>
		<tr class="b-filter">
			<td></td>
			<td><?php echo CHtml::activeTextField($filter, 'hou_name'); ?></td>
			<td><?php echo CHtml::activeDropDownList($filter, 'hou_rub_id', array(""=>"Все рубрики")+CHtml::listData(Rubric::model()->findAll(), 'rub_id', 'rub_name')); ?></td>
			<td><?php echo CHtml::activeDropDownList($filter, 'hou_typ_id', array(""=>"Все типы", "1"=>"1", "2"=>"2", "3"=>"3")); ?></td>
			<td><a href="#" class="b-clear-filter">Сбросить фильтр</a></td>
		</tr>
		<? if( count($data) ): ?>
			<? foreach ($data as $i => $item): ?>
				<tr>
					<td><? echo count($data)-$i; ?></td>
					<td class="align-left"><a class="b-tooltip" title="Посмотреть все статьи у этого дома" href="<?php echo Yii::app()->createUrl('/article/adminindex',array('Article[art_hou_id]'=>$item->hou_id))?>"><? echo $item->hou_name; ?></a></td>
					<td><? if( $item->rubric ) echo $item->rubric->rub_name; ?></td>
					<td><? echo $item->hou_typ_id; ?></td>
					<td><a href="<?php echo Yii::app()->createUrl('/house/adminupdate',array('id'=>$item->hou_id))?>" class="ajax-form ajax-update b-tool b-tool-update" title="Редактировать дом"></a><a href="<?php echo Yii::app()->createUrl('/house/admindelete',array('id'=>$item->hou_id))?>" class="ajax-form ajax-delete b-tool b-tool-delete" title="Удалить дом"></a></td>
				</tr>
			<? endforeach; ?>
		<? else: ?>
			<tr>
				<td colspan=10>Пусто</td>
			</tr>
		<? endif; ?>
	</table>
<?php $this->endWidget(); ?>