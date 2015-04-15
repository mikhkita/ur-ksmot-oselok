<div class="b-block">
	<ul class="b-rubrics clearfix">
		<? foreach ($data as $i => $item): ?>
			<a href="<?php echo Yii::app()->createUrl('/house/index',array('id'=>$item->rub_id))?>">
				<li class="b-rubric">
					<h3><? echo $item->rub_name ?></h3>
					<div style="background-image: url('<? echo (Yii::app()->request->baseUrl)."/".($item->rub_img); ?>');"></div>
					<span class="b-btn">Подробнее</span>
				</li>
			</a>
		<? endforeach; ?>
	</ul>
</div>