<?php
$start = microtime(true);

require_once __DIR__.'/../application/Application.php';

Application::init();

//админ
Request('GET', '/admin','Admin\Admin_index');

Request('GET', '/','Ctrl_index');
//авторизация
Request('GET', '/auth/login','User\Auth');

Application::run();


//cho '<br>';
//echo '<br>';
//echo '<br>';
echo '<br><br>Время генерации страницы: '. (microtime(true) - $start);

?>
