<div class="b-blog">
	<div class="b-blog-cont clearfix">
		<div class="left">
			<a class="b-butt-back" href="<?php echo Yii::app()->createUrl('/house/view',array('id'=>$model->house->hou_id))?>">Вернуться в комнату</a>
			<div id="accordion" class="b-accordion">
				<? foreach ($data as $i => $item): ?>
					<h3 <? if( $item->cat_id == $model->art_cat_id ) echo "class='b-active' data-id='".$i."'"; ?>><? echo $item->cat_name ?></h3>
					<div>
				    	<ul>
				    		<? foreach ($item->articles as $j => $article): ?>
				    			<? if( $article->art_id == $model->art_id ): ?>
				    				<li class="b-active"><a><? echo $article->art_title; ?></a></li>
				    			<? else: ?>
				    				<li><a href="<?php echo Yii::app()->createUrl('/article/index',array('id'=>$article->art_id))?>"><? echo $article->art_title; ?></a></li>
				    			<? endif; ?>
				    		<? endforeach; ?>
				    	</ul>
				  	</div>
				<? endforeach; ?>
			</div>
		</div>
		<div class="right">
			<div class="b-text">
				<h2><? echo $model->art_title; ?></h2>
				<div class="b-text-body">
					<? echo $model->art_text; ?>
				</div>
			</div>
		</div>
	</div>
</div>