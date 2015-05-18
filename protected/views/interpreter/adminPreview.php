<div class="b-popup b-interpreter-preview">
	<h1>Примеры</h1>

	<? foreach ($data as $item): ?>
	<div class="row">
		<p>
			Код товара: <?=$item["ID"]?>
		</p>
		<div>
			<?=$item["VALUE"]?>
		</div>
	</div>
	<?endforeach;?>
	<div class="row buttons">
		<input type="button" onclick="$.fancybox.close(); return false;" value="Закрыть">
	</div>
</div>