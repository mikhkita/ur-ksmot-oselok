<?php $this->renderPartial('_menu', array()); ?>
<input type='hidden' name="price_min" id="price_min" value="<?=$price_min?>">
<input type='hidden' name="price_max" id="price_max" value="<?=$price_max?>">
<div class="b b-item">
	<div class="b-block clearfix">
		<ul class="sub-menu hor clearfix">
			<li id="go-back"><?echo ( $_GET['type']==1 )?"Шины":"Диски"?> <span>><span></li>
		</ul>
		<h2><? if( $_GET['type']==1 ) echo Interpreter::generate(50, $good); if( $_GET['type']==2 ) echo "Тайтл дисков"?></h2>
		<div class="images left">

			<div id="bg-img" style="background-image:url('<?=$imgs[0]?>');"><a class="fancy-img-big" href="<?=$imgs[0]?>"></a></div>
			<ul class="hor clearfix">
				<? if (count($imgs)>1): ?>
					<? foreach ($imgs as $img): ?>
						<li style="background-image:url('<?=$img?>');"><a class="fancy-img-thumb" href="<?=$img?>"></a><a href="<?=$img?>" class="fancy-img" style="display:none !important;" rel="one"></a></li>
					<? endforeach; ?>
				<? endif; ?>
			</ul>
		</div>
		<div class="desc left">
			<div class="clearfix">
				<h3 class="left"><?=$good->fields_assoc[20]->value?> руб.</h3>
				<a class="red-btn right" href="#">Купить</a>
			</div>
			<ul>
				<? if(isset($good->fields_assoc[28])): ?>
				<li class="clearfix">
					<h4>Количество в комплекте:</h4>
					<h5><?=$good->fields_assoc[28]->value?> шт.</h5>
				</li>
				<? endif; ?>
				<? if(isset($good->fields_assoc[23])): ?>
				<li class="clearfix">
					<h4>Протектор:</h4>
					<h5><?=$good->fields_assoc[23]->value?></h5>
				</li>
				<? endif; ?>
				<? if(isset($good->fields_assoc[29])): ?>
				<li class="clearfix">
					<h4>Износ:</h4>
					<h5><?=$good->fields_assoc[29]->value?> %</h5>
				</li>
				<? endif; ?>
				<? if(isset($good->fields_assoc[9])): ?>
				<li class="clearfix">
					<h4>Посадочный диаметр:</h4>
					<h5><?=$good->fields_assoc[9]->value?>"</h5>
				</li>
				<? endif; ?>
				<? if(isset($good->fields_assoc[31])): ?>
				<li class="clearfix">
					<h4>Ширина диска:</h4>
					<h5><?=$good->fields_assoc[31]->value?>"</h5>
				</li>
				<? endif; ?>
				<? if(isset($good->fields_assoc[32])): ?>
				<li class="clearfix">
					<h4>Вылет:</h4>
					<h5><?=$good->fields_assoc[32]->value?> мм.</h5>
				</li>
				<? endif; ?>
				<? if(isset($good->fields_assoc[5])): ?>
				<li class="clearfix">
					<h4>Сверловка:</h4>
					<h5><?=$good->fields_assoc[5]->value?></h5>
				</li>
				<? endif; ?>
				<? if(isset($good->fields_assoc[7])): ?>
				<li class="clearfix">
					<h4>Ширина профиля:</h4>
					<h5><?=$good->fields_assoc[7]->value?> мм.</h5>
				</li>
				<? endif; ?>
				<? if(isset($good->fields_assoc[8])): ?>
				<li class="clearfix">
					<h4>Высота профиля:</h4>
					<h5><?=$good->fields_assoc[8]->value?> %</h5>
				</li>
				<? endif; ?>
				<? if(isset($good->fields_assoc[26])): ?>
				<li class="clearfix">
					<h4>Состояние товара:</h4>
					<h5><?=$good->fields_assoc[26]->value?></h5>
				</li>
				<? endif; ?>
			</ul> 
			<p><span>Описание: </span><? if( $_GET['type']==1 ) echo $this->replaceToBr(Interpreter::generate(10, $good)); if( $_GET['type']==2 ) echo "Описание дисков";?></p>
		</div>
		
	</div>
</div>