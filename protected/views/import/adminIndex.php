<h1><?=$this->adminMenu["cur"]->name?></h1>
<form action="#" method="POST">
	<? foreach ($data as $i => $item): ?>
		<label for="gt-<?=$item->id?>"><?=$item->name?></label>
	    <input id="gt-<?=$item->id?>" type="radio" name="good_type_id" value="<?=$item->id?>">
	<? endforeach; ?>
</form>