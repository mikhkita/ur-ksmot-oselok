<? 

foreach ($data as $item) {
	echo Interpreter::generate(1,$item->fields_assoc)."</br>"; 
}

?>