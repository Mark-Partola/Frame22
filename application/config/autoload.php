<?php

spl_autoload_register(function ($class) {

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