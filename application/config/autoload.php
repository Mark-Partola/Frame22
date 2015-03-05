<?php

/*function __autoload($classname) {
	$includeController = explode('_', $classname);
	$includeController = $includeController[0];
	switch($includeController){
		case 'Ctrl':
			require_once '../application/controllers/' . $classname .'.php';
			break;
		case 'Model':
			require_once '../application/models/' . $classname .'.php';
			break;
		default: 
			require_once '../application/' . $classname .'.php';
			break;
	}
}*/

spl_autoload_register(function ($class) {

	echo $class . '<br>';

	$base_dir = DOCUMENT_ROOT . '/application/';

	// получаем относительное имя класса
	$relative_class = substr($class, strripos($class, '\\')+1);

	$prefix = substr($class, 0, strpos($class, $relative_class));
	$prefix = strtolower($prefix);

	$filename = $base_dir . str_replace('\\', '/', $prefix . $relative_class) . '.php';

	//echo $filename;

	if (file_exists($filename)) {
		require_once $filename;
	}

});

?>