<?php $this->renderPartial('_menu', array()); ?>
<input type='hidden' name="price_min" id="price_min" value="<?=$price_min?>">
<input type='hidden' name="price_max" id="price_max" value="<?=$price_max?>">
<div class='b b-content'>
    <div class="b b-main">
        <div class="b-block clearfix">
            <div class="b-main-filter left">
                 <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'filter',
                    'action' => Yii::app()->createUrl('/shop/index'),
                    'enableAjaxValidation'=>false,
                    'method' => 'GET'
                )); ?>
                <div class="filter-cont">
                    <h2>Цена (руб)</h2>
                    <div class="slider-text clearfix">
                        <h3 class="left">от <span id="amount-l"><span></h3>
                        <h3 class="right" style="margin-right:7px;">до <span id="amount-r"><span></h3>
                        <input type='hidden' name="price-min" id="price-min" >
                        <input type='hidden' name="price-max" id="price-max" >
                        <input type='hidden' name="type" value="<?=$_GET['type']?>">
                    </div>
                    <div id="slider-range"></div>
                </div>
               

                <? $index = 1; foreach ($filter as $name => $items): ?>
                    <div class="filter-cont">
                        <h2><?=$name?></h2>
                        <div class="check-cont">
                            <ul class="hor clearfix">
                                <? foreach ($items as $item): ?>
                                <li>
                                    <input type="checkbox" id="f<?=$item['variant_id']?>" name="<?=$index?>[]" value="<?=$item['variant_id']?>" <?=$item['checked']?>>
                                    <label class="clearfix" for="f<?=$item['variant_id']?>">
                                        <span class="checked"></span>
                                        <span class="default"></span>   
                                        <h3><?=$item['value']?></h3>
                                    </label>
                                </li>
                                <? endforeach; ?>
                            </ul>
                        </div>  
                    </div>
                <? $index++; endforeach; ?>
                <!-- <input type="submit" value="Далее"> -->
                <?php $this->endWidget(); ?>
            </div>
            <div class="b-main-items left">
                <?php $this->renderPartial('_list', array('goods'=>$goods,'pages' => $pages)); ?>
            </div>
        </div>
    </div>
</div>
