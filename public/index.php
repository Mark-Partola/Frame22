<?php
//$start = microtime(true);

require_once __DIR__.'/../application/Application.php';

Application::init();

/***APPLICATION***/

Request('GET', '/products','Application\ProductsController:getAllProducts');
Request('GET', '/products/all','Application\ProductsController:getAllPropsForElem'); //test
Request('GET', '/products/{id}','Application\ProductsController:getProductById');

/***END APPLICATION***/

//админ
Request('GET', '/admin','Admin\Admin_index');
Request('GET', '/admin/{content}','Admin\Admin_index:getContent'); //assert

//Создать пользователя
Request('POST', '/admin/users/create','Admin\Admin_index:createUser');
//Создать роль
Request('POST', '/admin/action/create','Admin\Admin_index:createAction');
//Обновить элемент
Request('POST', '/admin/content/update/{id}','Admin\Admin_index:updateElem'); //assert

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
