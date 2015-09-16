<? if(count($model)): ?>
<div class="pagination">
    <ul class="yahoo-list">
    	<? foreach ($model as $item): ?>
			<li class="">
              <div class="image-cont" style="background-image:url('<?=$item->image?>');"></div>
              <h3><?=$item->title?></h3>
              <h4>Цена: <?=$item->cur_price?></h4>
              <h5>Количество ставок: <?=$item->bids?></h5>
              <h6><? $date = new DateTime($item->end_time); echo date_format($date, 'd.m.y H:i:s');?></h6>
			</li>
		<? endforeach; ?>
    </ul>  
    <?php $this->widget('CLinkPager', array(
        'header' => '',
        'lastPageLabel' => $pages->getPageCount(), 
        'pages' => $pages,
    )) ?>
</div>  
<? else: ?>
    <h3 class="b-no-goods">Товаров не найдено</h3>
<? endif; ?>
