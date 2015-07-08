<div class="b b-menu">
    <div class="b-block clearfix">
        <ul class="hor left clearfix">
            <li <? if( $_GET['type']==1 ) echo 'class="active" onclick="return false;"'; ?> ><a href="<?=Yii::app()->createUrl('/shop/index',array("type"=>"1"))?>">Шины</a></li>
            <li <? if( $_GET['type']==2 ) echo 'class="active" onclick="return false;"'; ?> ><a href="<?=Yii::app()->createUrl('/shop/index',array("type"=>"2"))?>">Диски</a></li>    
            <li><a href="#">Контакты</a></li>
        </ul>
       <!--  <form class="right" action="#" method="POST" novalidate="novalidate">
            <input type="text" name="search" placeholder="Поиск">
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/i/search-shop.png" alt="">
        </form> -->
    </div>
</div>
<div class="b b-item">
	<div class="b-block clearfix">
		<ul class="sub-menu hor clearfix">
			<li id="go-back"><?echo ( $_GET['type']==1 )?"Шины":"Диски"?> <span>><span></li>
		</ul>
		
<<<<<<< HEAD
		<h2><? if( $_GET['type']==1 ) echo Interpreter::generate(8, $good); if( $_GET['type']==2 ) echo Interpreter::generate(8, $good);?></h2>
=======
		<h2><?=Interpreter::generate(48, $good)?></h2>
>>>>>>> 6819ba6b6f57d38d96af10a6d959116efa6f9592
		<div class="images left">

			<div id="bg-img" style="background-image:url('<?=$imgs[0]?>');"><a class="fancy-img" href="<?=$imgs[0]?>"></a></div>
			<ul class="hor clearfix">
				<? if (count($imgs)>1): ?>
					<? foreach ($imgs as $img): ?>
						<li style="background-image:url('<?=$img?>');"><a href="<?=$img?>"></a></li>
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
			<p><span>Описание: </span><? if( $_GET['type']==1 ) echo $this->replaceToBr(Interpreter::generate(10, $good)); if( $_GET['type']==2 ) echo $this->replaceToBr(Interpreter::generate(10, $good));?></p>
		</div>
		
	</div>
</div>