<h1>Разделы</h1>
<table class="b-table" border="1">
	<tr>
		<th style="width: 30px;">№</th>
		<th><? echo $labels['rub_name']; ?></th>
		<th style="width: 125px;"><? echo $labels['rub_sort']; ?></th>
		<!-- <th style="width: 135px;"><? echo $labels['rub_img']; ?></th> -->
		<th style="width: 150px;">Действия</th>
	</tr>
	<? foreach ($data as $i => $item): ?>
		<tr>
			<td><? echo $i+1; ?></td>
			<td class="align-left"><a class="b-tooltip" title="Посмотреть все дома этого раздела" href="<?php echo Yii::app()->createUrl('/house/adminIndex',array("House[hou_rub_id]"=>$item->rub_id))?>"><? echo $item->rub_name; ?></a></td>
			<td><? echo $item->rub_sort; ?></td>
			<!-- <td><? echo $item->rub_img; ?></td> -->
			<td><a href="<?php echo Yii::app()->createUrl('/rubric/adminUpdate',array('id'=>$item->rub_id))?>" class="ajax-form ajax-update b-tool b-tool-update" title="Редактировать раздел"></a><a href="<?php echo Yii::app()->createUrl('/rubric/adminDelete',array('id'=>$item->rub_id))?>" class="ajax-form ajax-delete b-tool b-tool-delete" title="Удалить раздел"></a></td>
		</tr>
	<? endforeach; ?>
</table>
<a href="<?php echo $this->createUrl('/rubric/adminCreate')?>" class="ajax-form ajax-create b-butt">Добавить</a>
