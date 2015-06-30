<div class="pagination">
    <ul>
    	<? foreach ($goods as $good): ?>
			<li class="clearfix good" data-id='<?=$good["id"]?>'>
                <div class="img left" style="background-image: url(<?=Yii::app()->request->baseUrl?>/<?=Yii::app()->params["imageFolder"]?>/tires/<?=$good["CODE"]?>/<?=$good["CODE"]?>_00.jpg);"></div>
           		<div class="desc left">
                	<h3><?=$good["SEASON"]?> <?=$good["TIRE_BRAND"]?> <?=$good["TIRE_MODEL"]?> <?=$good["TIRE_WIDTH"]?>/<?=$good["TIRE_PROFILE"]?>/<?=$good["DIAMETER"]?> (<?=$good["COUNTRY"]?>) <?=$good["CONDITION"]?></h3>
                	<h4><?=$good["TIRE_WIDTH"]?>/<?=$good["TIRE_PROFILE"]?>/<?=$good["DIAMETER"]?>, <?=$good["SEASON"]?>, износ <?=$good["WEAR"]?>%, <?=$good["AMOUNT"]?> шт.</h4>
                	<h5><?=$good["PRICE"]?> руб.<span> + доставка 500 руб.</span></h5>
           	    </div>
			</li>
		<? endforeach; ?>
    </ul>  
    <?php $this->widget('CLinkPager', array(
        'header' => '',
        'firstPageLabel' => '1', 
        'lastPageLabel' => $pages->getPageCount(), 
        'cssFile' => Yii::app()->request->baseUrl.'/css/shop.css',
        'maxButtonCount' => 5,
        'pages' => $pages,
        'htmlOptions' => array("class"=>"yiiPager hor clearfix")
    )) ?>
</div>  