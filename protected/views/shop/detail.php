<?php $this->renderPartial('_menu', array()); ?>
<div class="b b-item">
	<div class="b-block clearfix">
		<ul class="sub-menu hor clearfix">
			<li id="go-back"><?=$this->params[$_GET['type']]["NAME"]?> <span>><span></li>
		</ul>
		<h2 id="b-good-title"><?=Interpreter::generate($this->params[$_GET['type']]["TITLE_CODE"], $good);?></h2>
		<div class="clearfix">
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
					<h3 class="left"><?=(!$good->fields_assoc[20]->value )? Yii::app()->params["zeroPrice"] : number_format( $good->fields_assoc[20]->value, 0, ',', ' ' )." руб."?></h3>
					<a class="red-btn right fancy" data-afterShow="myHandler" data-block="#b-popup-buy" href="#">Купить</a>
				</div>
				<ul>
					<? if(isset($good->fields_assoc[28]->value)): ?>
					<li class="clearfix">
						<h4>Количество в комплекте:</h4>
						<h5><?=$good->fields_assoc[28]->value?> шт.</h5>
					</li>
					<? endif; ?>
					<? if(isset($good->fields_assoc[23]->value)): ?>
					<li class="clearfix">
						<h4>Протектор:</h4>
						<h5><?=$good->fields_assoc[23]->value?></h5>
					</li>
					<? endif; ?>
					<? if(isset($good->fields_assoc[29]->value)): ?>
					<li class="clearfix">
						<h4>Износ:</h4>
						<h5><?=$good->fields_assoc[29]->value?> %</h5>
					</li>
					<? endif; ?>
					<? if(isset($good->fields_assoc[9]->value)): ?>
					<li class="clearfix">
						<h4>Посадочный диаметр:</h4>
						<h5><?=$good->fields_assoc[9]->value?>"</h5>
					</li>
					<? endif; ?>
					<? if(isset($good->fields_assoc[31]->value)): ?>
					<li class="clearfix">
						<h4>Ширина диска:</h4>
						<h5><?=$good->fields_assoc[31]->value?>"</h5>
					</li>
					<? endif; ?>
					<? if(isset($good->fields_assoc[32]->value)): ?>
					<li class="clearfix">
						<h4>Вылет:</h4>
						<h5><?=$good->fields_assoc[32]->value?> мм.</h5>
					</li>
					<? endif; ?>
					<? if(isset($good->fields_assoc[5]->value)): ?>
					<li class="clearfix">
						<h4>Сверловка:</h4>
						<h5><?=$good->fields_assoc[5]->value?></h5>
					</li>
					<? endif; ?>
					<? if(isset($good->fields_assoc[7]->value)): ?>
					<li class="clearfix">
						<h4>Ширина профиля:</h4>
						<h5><?=$good->fields_assoc[7]->value?> мм.</h5>
					</li>
					<? endif; ?>
					<? if(isset($good->fields_assoc[8]->value)): ?>
					<li class="clearfix">
						<h4>Высота профиля:</h4>
						<h5><?=$good->fields_assoc[8]->value?> %</h5>
					</li>
					<? endif; ?>
					<? if(isset($good->fields_assoc[26]->value)): ?>
					<li class="clearfix">
						<h4>Состояние товара:</h4>
						<h5><?=$good->fields_assoc[26]->value?></h5>
					</li>
					<? endif; ?>
					<? if(isset($good->fields_assoc[27]->value)): ?>
					<li class="clearfix">
						<h4>Местонахождение товара:</h4>
						<h5><?=$good->fields_assoc[27]->value?></h5>
					</li>
					<? endif; ?>
				</ul> 
				<p><span style="display:none;">Описание: </span><?=$this->replaceToBr(Interpreter::generate($this->params[$_GET['type']]["DESCRIPTION_CODE"], $good));?></p>
			</div>
		</div>
		<h4>Гарантия и условия возврата: </h4>
		<p><?=$this->replaceToBr(Interpreter::generate($this->params[$_GET['type']]["GARANTY_CODE"], $good));?></p>
	</div>
</div>