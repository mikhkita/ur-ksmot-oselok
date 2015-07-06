<div class="b b-item">
	<div class="b-block clearfix">
		<ul class="sub-menu hor clearfix">
			<li>Шины <span>><span></li>
		</ul>
		
		<h2><?=Interpreter::generate(8, $good)?></h2>
		<div class="images left">

			<div id="bg-img" style="background-image:url('<?=$imgs[0]?>');"><a class="fancy-img" href="<?=$imgs[0]?>"></a></div>
			<ul class="hor clearfix">
				<? foreach ($imgs as $img): ?>
				<li style="background-image:url('<?=$img?>');"><a href="<?=$img?>"></a></li>
				<? endforeach; ?>
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
					<h4>Количество шин в комплекте:</h4>
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
			<p><span>Описание:</span> <? echo $this->replaceToBr(Interpreter::generate(10, $good))?></p>
		</div>
		
	</div>
</div>