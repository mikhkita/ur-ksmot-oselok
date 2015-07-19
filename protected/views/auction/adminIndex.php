<h1><?=$this->adminMenu["cur"]->name?></h1>
<a href="<?php echo $this->createUrl('/'.$this->adminMenu["cur"]->code.'/admincreate')?>" class="ajax-form ajax-create b-butt b-top-butt">Добавить</a>
<?php $form=$this->beginWidget('CActiveForm'); ?>
	<table class="b-table" border="1">
		<tr>
			<th><? echo $labels['code']; ?></th>
			<th style="min-width: 100px;"><? echo $labels['image']; ?></th>
			<th><? echo $labels['name']; ?></th>
			<th style="min-width: 145px;"><? echo $labels['date']; ?></th>
			<th><? echo $labels['current_price']; ?></th>
			<th style="min-width: 140px;"><? echo $labels['state']; ?></th>
			<th><? echo $labels['price']; ?></th>
			<th style="min-width: 130px;">Действия</th>
		</tr>
		<tr class="b-filter">
			<td><?php echo CHtml::activeTextField($filter, 'code'); ?></td>
			<td></td>
			<td><?php echo CHtml::activeTextField($filter, 'name'); ?></td>
			<td><?php echo CHtml::activeTextField($filter, 'date'); ?></td>
			<td><?php echo CHtml::activeTextField($filter, 'current_price'); ?></td>
			<td></td>
			<td><?php echo CHtml::activeTextField($filter, 'price'); ?></td>
			<td><a href="#" class="b-clear-filter">Сбросить фильтр</a></td>
		</tr>
		<? if( count($data) ): ?>
			<? foreach ($data as $i => $item): ?>
				<tr>
					<td class="align-left"><?=$item->code?></td>
					<td class="align-left"><a href="<?=$item->image?>" class="fancy-img"><img src="<?=$item->image?>" class="b-index-img"></a></td>
					<td class="align-left"><?=$item->name?></td>
					<td><?=$item->date?></td>
					<td class="align-left"><?=$item->current_price?></td>
					<td><?=Auction::model()->states[$item->state]?></td>
					<td class="align-left"><?=$item->price?></td>
					<td class="b-tool-cont">
						<a href="<?php echo Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/adminupdate',array('id'=>$item->id))?>" class="ajax-form ajax-update b-tool b-tool-update" title="Редактировать <?=$this->adminMenu["cur"]->vin_name?>"></a>
						<a href="<?php echo Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/admindelete',array('id'=>$item->id))?>" class="ajax-form ajax-delete b-tool b-tool-delete" data-warning="Вы действительно хотите удалить <?=$this->adminMenu["cur"]->vin_name?> &quot;<?=$item->name?>&quot;?" title="Удалить <?=$this->adminMenu["cur"]->vin_name?>"></a>
					</td>
				</tr>
			<? endforeach; ?>
		<? else: ?>
			<tr>
				<td colspan=10>Пусто</td>
			</tr>
		<? endif; ?>
	</table>
<?php $this->endWidget(); ?>