<div class="pagination">
    <ul>
    	<? foreach ($goods as $good): ?>
			<li class="clearfix good">
               <a href="<?=Yii::app()->createUrl('/shop/detail',array('type'=> $_GET['type'],"id"=>$good->id))?>">
                    <div class="img" style="background-image: url(<? $images = $this->getImages($good); echo $images[0];?>);"></div>
                <div class="desc">
                    <h3><? if( $_GET['type']==1 ) echo Interpreter::generate(50, $good); if( $_GET['type']==2 ) echo "Тайтл дисков"?></h3>
                    <h4><? if( $_GET['type']==1 ) echo Interpreter::generate(13, $good); if( $_GET['type']==2 ) echo "тайтл-2 дисков"?></h4>
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


