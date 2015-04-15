<div class="b-top-menu">
	<div class="b-edit clearfix">
		<span>Режим пометки</span>
		<a href="#" class="b-ajax-link switcher checked<? echo ((intval($word->word->attributes["wrd_id"]))?" checked":""); ?>">
		    <div class="rail">
		        <div class="state1">Вкл.</div>
		        <div class="slider"></div>
		        <div class="state2">Выкл.</div>
		    </div>
		</a>
	</div>
</div>
<h1 class="b-text-title"><? echo $item->attributes["txt_title"]; ?></h1>
<ul class="b-words" style="display:none;">
	<? foreach ($item->words as $i => $word): ?>
		<li class="b-word" data-translate="<? echo $word->word->attributes["wrd_translation"]; ?>" data-t="<? echo strtolower($word->word->attributes["wrd_text"]); ?>" ></li>
	<? endforeach; ?>
</ul>
<div class="b-text" data-id="<? echo $item->attributes["txt_id"] ?>" data-url="<?php echo $this->createUrl('/words/translate')?>" data-remove-url="<?php echo $this->createUrl('/words/remove')?>">
	<div class="b-bubble">
		<div class="b-overlay"></div>
        <div class="b-bubble-p">
            <p></p>
        </div>
        <div class="b-corner"><span></span></div>
    </div>
	<? echo nl2br($this->parseText($item->attributes["txt_text"])); ?>
</div>