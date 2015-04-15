<h1>Статьи</h1>
<a href="<?php echo $this->createUrl('/article/admincreate')?>" class="ajax-form ajax-create b-butt b-top-butt">Добавить</a>
<?php $form=$this->beginWidget('CActiveForm'); ?>
	<table class="b-table" border="1">
		<tr>
			<th style="width: 30px;">№</th>
			<th><? echo $labels['art_title']; ?></th>
			<th style="width: 145px;"><? echo $labels['art_cat_id']; ?></th>
			<th style="width: 135px;"><? echo $labels['art_hou_id']; ?></th>
			<th style="width: 150px;">Действия</th>
		</tr>
		<tr class="b-filter">
			<td></td>
			<td><?php echo CHtml::activeTextField($filter, 'art_title'); ?></td>
			<td><?php echo CHtml::activeDropDownList($filter, 'art_cat_id', array(""=>"Все категории")+CHtml::listData(Category::model()->findAll(array('order'=>'cat_name ASC')), 'cat_id', 'cat_name')); ?></td>
			<td><?php echo CHtml::activeDropDownList($filter, 'art_hou_id', array(""=>"Все дома")+CHtml::listData(House::model()->findAll(array('order'=>'hou_name ASC')), 'hou_id', 'hou_name') ); ?></td>
			<td><a href="#" class="b-clear-filter">Сбросить фильтр</a></td>
		</tr>
		<? if( count($data) ): ?>
			<? foreach ($data as $i => $item): ?>
				<tr>
					<td><? echo count($data)-$i; ?></td>
					<td class="align-left"><? echo $item->art_title; ?></td>
					<td><? if( $item->category ) echo $item->category->cat_name; ?></td>
					<td><? if( $item->house ) echo $item->house->hou_name; ?></td>
					<td><a href="<?php echo Yii::app()->createUrl('/article/adminupdate',array('id'=>$item->art_id))?>" class="ajax-form ajax-update b-tool b-tool-update" title="Редактировать статью"></a><a href="<?php echo Yii::app()->createUrl('/article/admindelete',array('id'=>$item->art_id))?>" class="ajax-form ajax-delete b-tool b-tool-delete" title="Удалить статью"></a></td>
				</tr>
			<? endforeach; ?>
		<? else: ?>
			<tr>
				<td colspan=10>Пусто</td>
			</tr>
		<? endif; ?>
	</table>
<?php $this->endWidget(); ?>