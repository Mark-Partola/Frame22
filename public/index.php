<?php
//$start = microtime(true);

require_once __DIR__.'/../application/Application.php';

Application::init();

//главная
Request('GET', '/','Ctrl_index');

Application::run();


//cho '<br>';
//echo '<br>';
//echo '<br>';
//echo 'Время генерации страницы: '. (microtime(true) - $start);

?>
