<?php
//$start = microtime(true);

require_once __DIR__.'/../application/Application.php';

Application::init();

/***APPLICATION***/

Request('GET', '/','Ctrl_index');
Request('GET', '/shop','Ctrl_index:getCats');
Request('GET', '/category/{id}','Ctrl_index:getCatById');
//все продукты
Request('GET', '/products/limit/{limit}','Application\ProductsController:getAllProducts');
//продукты по фильтру
Request('GET', '/products/filter','Application\ProductsController:getProductsByFilter');

//Получить свойства
Request('GET', '/elems/props/{id}','Application\ProductsController:getAllPropsForElem');
//Сохранить свойства
Request('POST', '/elems/props/{id}','Application\ProductsController:savePropsForElem');
//Установить главную картинку
Request('POST', '/elems/{id}/image/','Application\ProductsController:saveMainImage');
//Изменение статуса элемента
Request('POST', '/elems/{id}/status/','Application\ProductsController:changeStatus');
//Конкретный продукт
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


/*
* Авторизация
*/
Request('GET', '/auth/login','User\Auth'); //показать страницу
Request('POST', '/auth/login','User\Auth:login'); //проверка логина/пароля
Request('GET', '/auth/logout','User\Auth:logout'); //проверка логина/пароля





Request('GET', '/uploads/images/','System\UploadsController:getAllImages');




Application::run();


/*echo '<br>';
echo '<br>';
echo '<br>';
echo '<br><br>Время генерации страницы: '. (microtime(true) - $start);*/

?>
