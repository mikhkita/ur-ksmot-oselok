<? foreach ($allAttr["ATTRIBUTES"] as $key => $value): ?>
<li class="ui-state-default" data-id="<?=$value?>"><p><?=$value?></p><input type="hidden" name="attributes[<?=$key?>]" value="<?=$value?>"></li>
<? endforeach; ?>

<? foreach ($allAttr["INTERPRETERS"] as $key => $value): ?>
<li class="ui-state-default" data-id="<?=$value?>"><p><?=$value?></p><input type="hidden" name="interpreters[<?=$key?>]" value="<?=$value?>"></li>
<? endforeach; ?>