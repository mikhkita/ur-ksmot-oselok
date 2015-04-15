<div class="b-popup">
    <h1>Дома</h1>
    <div id="accordion" class="b-accordion">
        <? foreach ($model as $i => $item): ?>
            <? if( count($item->houses) ): ?>
                <h3><? echo $item->rub_name; ?></h3>
                <div>
                    <ul class="b-selectable">
                        <? foreach ($item->houses as $j => $house): ?>
                            <li <? if( $exist[$house->hou_id] == 1 ) echo 'class="active"'; ?> data-url="<?php echo Yii::app()->createUrl('/categoryhouse/admintoggle',array('one_name'=>'cat_id', 'one_val'=>$id, 'two_name'=>'hou_id', 'two_val'=>$house->hou_id))?>" ><? echo $house->hou_name; ?></li>
                        <? endforeach; ?>
                    </ul>
                </div>
            <? endif; ?>
        <? endforeach; ?>
    </div>

    <div class="row buttons">
        <input type="button" onclick="$.fancybox.close(); return false;" value="Готово">
    </div>
</div>