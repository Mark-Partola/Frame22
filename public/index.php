<?php
//$start = microtime(true);

require_once __DIR__.'/../application/Application.php';

Application::init();

//админ
Request('GET', '/admin','Admin\Admin_index');

Request('GET', '/','Ctrl_index');

/*
* Авторизация
*/
Request('GET', '/auth/login','User\Auth'); //показать страницу
Request('POST', '/auth/login','User\Auth:login'); //проверка логина/пароля
Request('GET', '/auth/logout','User\Auth:logout'); //проверка логина/пароля

Application::run();


/*echo '<br>';
echo '<br>';
echo '<br>';
echo '<br><br>Время генерации страницы: '. (microtime(true) - $start);*/

?>
