<div class="b b-item">
	<div class="b-block clearfix">
		<ul class="sub-menu hor clearfix">
			<li>Диски <span>><span></li>
		</ul>
		
		<h2><?=$good["TITLE"]['VALUE']?></h2>
		<div class="images left">
			<div id="bg-img" style="background-image:url('i/wheel.jpg');"><a class="fancy-img" href="i/wheel.jpg"></a></div>
			<ul class="hor clearfix">
				<li style="background-image:url('i/wheel.jpg');"><a href="i/wheel.jpg"></a></li>
				<li style="background-image:url('i/22.jpg');"><a href="i/22.jpg"></a></li>
				<li style="background-image:url('i/wheel.jpg');"><a href="i/wheel.jpg"></a></li>
				<li style="background-image:url('i/wheel.jpg');"><a href="i/wheel.jpg"></a></li>
				<li style="background-image:url('i/wheel.jpg');"><a href="i/wheel.jpg"></a></li>
				<li style="background-image:url('i/wheel.jpg');"><a href="i/wheel.jpg"></a></li>
			</ul>
		</div>
		<div class="desc left">
			<div class="clearfix">
				<h3 class="left"><?=$good["PRICE"]['VALUE']?> руб.</h3>
				<a class="red-btn right" href="#">Купить</a>
			</div>
			<ul>
				<? if(isset($good["AMOUNT"])): ?>
				<li class="clearfix">
					<h4><?=$good["AMOUNT"]['NAME']?>:</h4>
					<h5><?=$good["AMOUNT"]['VALUE']?> шт.</h5>
				</li>
				<? endif; ?>
				<? if(isset($good["DIAMETER"])): ?>
				<li class="clearfix">
					<h4><?=$good["DIAMETER"]['NAME']?>:</h4>
					<h5><?=$good["DIAMETER"]['VALUE']?>"</h5>
				</li>
				<? endif; ?>
				<? if(isset($good["TIRE_WIDTH"])): ?>
				<li class="clearfix">
					<h4><?=$good["TIRE_WIDTH"]['NAME']?>:</h4>
					<h5><?=$good["TIRE_WIDTH"]['VALUE']?>"</h5>
				</li>
				<? endif; ?>
				<? if(isset($good["SVERLOVKA"])): ?>
				<li class="clearfix">
					<h4><?=$good["SVERLOVKA"]['NAME']?>:</h4>
					<h5><?=$good["SVERLOVKA"]['VALUE']?></h5>
				</li>
				<? endif; ?>
				<? if(isset($good["CONDITION"])): ?>
				<li class="clearfix">
					<h4><?=$good["CONDITION"]['NAME']?>:</h4>
					<h5><?=$good["CONDITION"]['VALUE']?></h5>
				</li>
				<? endif; ?>
			</ul>
			<p><span>Описание:</span> Диски с японского аукциона, без  пробега по РФ. Находятся в Томске. Продаются без шин, шины выложены отдельно в нашей базе. Без погнутостей, трещин, следов ремонта. Товар б/у.</p>
		</div>
		
	</div>
</div>