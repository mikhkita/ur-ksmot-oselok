<div class="b-room">
	<div class="b-cabinet"></div>
</div>
<div style="display:none;">
	<div class="b-popup-main" id="b-popup-1">
		<ul class="b-categories">
			<? foreach ($data as $i => $item): ?>
				<li class="b-category">
					<h3><? echo $item->cat_name; ?></h3>
					<p><? echo $item->cat_text; ?></p>
					<a href="<?php echo Yii::app()->createUrl('/article/index',array('id'=>$item->articles[0]->art_id))?>" class="b-btn">Подробнее</a>
				</li>
			<? endforeach; ?>
		</ul>
	</div>
</div>