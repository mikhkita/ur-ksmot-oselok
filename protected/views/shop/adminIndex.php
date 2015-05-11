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
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'filter',
                    'action' => Yii::app()->createUrl('/admin/shop/filter'),
                    'enableAjaxValidation'=>false
                )); ?>

                <? foreach ($filter as $name => $items): ?>
                        <div class="filter-cont">
                            <h2><?=$name?></h2>
                            <div class="check-cont">
                                <ul class="hor clearfix">
                                    <? foreach ($items as $i => $item): ?>
                                        <? if($i!='code'): ?>
                                    <li>
                                        <input type="checkbox" id="<?=$items['code'].'-'.$i?>" name="<?=$items['code'].'['.$i.']'?>" value="<?=$item['id']?>" >
                                        <label class="clearfix" for="<?=$items['code'].'-'.$i?>">
                                            <span class="checked"></span>
                                            <span class="default"></span>   
                                            <h3><?=$item['value']?></h3>
                                        </label>
                                    </li>
                                        <? endif; ?>
                                    <? endforeach; ?>
                                </ul>
                            </div>  
                        </div>
                <? endforeach; ?>
                <input type="submit" value="Далее">
                <?php $this->endWidget(); ?>
            </div>
            <div class="b-main-items left">
                <?php $this->renderPartial('_list', array('goods'=>$goods,'pages' => $pages)); ?>
            </div>
        </div>
    </div>


