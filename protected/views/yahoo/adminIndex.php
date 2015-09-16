<h1><?=$this->adminMenu["cur"]->name?></h1>
<div class="b-link-back">
    <a href="#" class="b-select-all">Выделить все</a>
    <a href=""><?=$pages->offset?></a>
    <a href="<?php echo Yii::app()->createUrl('/'.$this->adminMenu["cur"]->code.'/admindelete',array('page'=> $pages->getCurrentPage() ))?>" class="b-delete-selected">Удалить выбранное</a>
</div>
<? if(count($model)): ?>
<div class="pagination">
    <ul class="yahoo-list">
    	<? foreach ($model as $item): ?>
			<li class="" data-id="<?=$item->id?>">
                <div class="image-cont" style="background-image:url('<?=$item->image?>');">
                    <div class="b-nav">
                        <span class="b-nav-delete b-tooltip" title="Не показывать лот"></span>
                        <span class="b-nav-sniper b-tooltip" title="Добавить в снайпер"></span>
                    </div>
                </div>
                <!-- <h3><?=$item->title?></h3> -->
                <div class="clearfix">
                    <h4 class="left">Цена: <b><?=$item->cur_price?></b></h4>
                    <h5 class="right">Ставок: <b><?=$item->bids?></b></h5>
                </div>
                <div class="clearfix">
                    <h4 class="left">Окончание:</h4>
                    <h5 class="right"><? $date = new DateTime($item->end_time); echo date_format($date, 'd.m.y H:i');?></h5>
                </div>
			</li>
		<? endforeach; ?>
    </ul>  
    <?php $this->widget('CLinkPager', array(
        'header' => '',
        'lastPageLabel' => 'последняя &raquo;',
        'firstPageLabel' => '&laquo; первая', 
        'pages' => $pages,
        'prevPageLabel' => '< назад',
        'nextPageLabel' => 'далее >'
    )) ?>
</div>  
<? else: ?>
    <h3 class="b-no-goods">Лотов не найдено</h3>
<? endif; ?>
