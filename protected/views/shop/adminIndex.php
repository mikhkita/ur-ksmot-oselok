<div class="b b-main">
        <div class="b-block clearfix">
            <div class="b-main-filter left">
                <div class="filter-cont">
                    <h2>Цена (руб)</h2>
                    <div class="slider-text clearfix">
                        <h3 class="left">от <span id="amount-l">1000<span></h3>
                        <h3 class="right" style="margin-right:7px;">до <span id="amount-r">36000<span></h3>
                    </div>
                    <div id="slider-range"></div>
                </div>
                <div class="filter-cont">
                    <h2>Состояние</h2>
                    <div class="check-cont">
                        <ul class="hor clearfix">
                            <li>
                                <input type="checkbox" id="sost-1">
                                <label class="clearfix" for="sost-1">
                                    <span class="checked"></span>
                                    <span class="default"></span>   
                                    <h3>Б/у</h3>
                                </label>
                            </li>
                            <li>
                                <input type="checkbox" id="sost-2">
                                <label class="clearfix" for="sost-2">
                                    <span class="checked"></span>
                                    <span class="default"></span>
                                    <h3>Как новый</h3>
                                </label>
                            </li>
                        </ul>
                    </div>  
                </div>
                <div class="filter-cont">
                    <h2>Состояние</h2>
                    <div class="check-cont">
                        <ul class="hor clearfix">
                            <li>
                                <input type="checkbox" id="sost-3">
                                <label class="clearfix" for="sost-3">
                                    <span class="checked"></span>
                                    <span class="default"></span>
                                    <h3>Литой</h3>
                                </label>
                            </li>
                            <li>
                                <input type="checkbox" id="sost-4">
                                <label class="clearfix" for="sost-4">
                                    <span class="checked"></span>
                                    <span class="default"></span>
                                    <h3>Кованый</h3>
                                </label>
                            </li>
                            <li>
                                <input type="checkbox" id="sost-5">
                                <label class="clearfix" for="sost-5">
                                    <span class="checked"></span>
                                    <span class="default"></span>
                                    <h3>Штампованный</h3>
                                </label>
                            </li>
                        </ul>
                    </div>  
                </div>
            </div>
            <div class="b-main-items left">
                <ul>
                	<? foreach ($goods as $good): ?>
						<li class="clearfix">
							<img class="left" src="<?php echo Yii::app()->request->baseUrl; ?>/i/item-1.jpg" alt="">
                       		<div class="left">
                            	<h3><?=$good["title"]?></h3>
                            	<h4>7.5x18 ET37 114.30x5</h4>
                            	<h5><?=$good["price"]?> руб.<span> + доставка 500 руб.</span></h5>
                       	    </div>
						</li>
					<? endforeach; ?>
                </ul>   
            </div>  
            <ul class="hor b-pagination clearfix">
                <li><a href="">1</a></li>
                <li><a href="">2</a></li>
                <li><a href="">3</a></li>
                <li><a href="">4</a></li>
                <li><a href="">5</a></li>
                <li class="points">...</li>
                <li><a href="">10</a></li>
            </ul>
        </div>
    </div>


