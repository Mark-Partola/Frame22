<?php

function __autoload($classname) {
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
}

?>