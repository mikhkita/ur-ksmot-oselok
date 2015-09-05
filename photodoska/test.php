<?

$arr = array("Заголовок","Количество","Диаметр","Модель диска","Ширина диска","Вылет","Сверловка","Описание","Вид торгов","Блиц-цена","Проверка","Город");

$word = "Ширина";

foreach ($arr as $i => $val) {
	$eq = similar_text($word,$val);
	$percent = round(($eq/similar_text($val,$val)+$eq/similar_text($word,$word))/2*100);

	echo $percent."% ".$val."<br>";
}

?>