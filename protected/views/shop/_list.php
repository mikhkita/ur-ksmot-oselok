<? if(count($goods)): ?>
<div class="pagination">
    <ul>
    	<? foreach ($goods as $good): ?>
			<li class="clearfix good">
               <a href="<?=Yii::app()->createUrl('/shop/detail',array('type'=> $_GET['type'],"id"=>$good->fields_assoc[3]->value))?>">
                    <div class="img" style="background-image: url(<? $images = $this->getImages($good); echo $images[0];?>);"></div>
                <div class="desc">
                    <h3><?=Interpreter::generate($this->params[$_GET['type']]["TITLE_CODE"], $good);?></h3>
                    <h4><?=Interpreter::generate($this->params[$_GET['type']]["TITLE_2_CODE"], $good);?></h4>
                    <? $price = 0; $price = Interpreter::generate($this->params[$_GET['type']]["PRICE_CODE"], $good); $order = Interpreter::generate($this->params[$_GET['type']]["ORDER"], $good); ?>
                    <h5><?=$price==0 ? Yii::app()->params["zeroPrice"] : number_format( $price, 0, ',', ' ' )." руб."?> <span><? if($order) echo "(".$order.")"; ?></span></h5>
                </div>
            </a>
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
<? else: ?>
    <h3 class="b-no-goods">Товаров не найдено</h3>
<? endif; ?>
