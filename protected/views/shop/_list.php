<div class="pagination">
    <ul>
    	<? foreach ($goods as $good): ?>
			<li class="clearfix good">
               <a href="<?=Yii::app()->createUrl('/shop/detail',array('type'=> $_GET['type'],"id"=>$good->id))?>">
                    <div class="img" style="background-image: url(<? $images = $this->getImages($good); echo $images[0];?>);"></div>
                <div class="desc">
                    <h3><?=Interpreter::generate(50, $good)?></h3>
                    <h4><?=Interpreter::generate(13, $good)?></h4>
                    <h5><?=$good->fields_assoc[20]->value?> руб.</h5>
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


