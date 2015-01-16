<?php

function filter_empty_str($value) {
	return $value != '';
}

function clear_str($str) {
	return strip_tags(trim($str));
}

function isAjax() {
	return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

/*
 *Обертка для класса, чтобы все роуты писать в одну строку
 */
function Request($method, $path, $callback) {
	return new Request($method, $path, $callback);
}


class Request {

	public $method;
	public $path;
	public $callback;
	public $asserts = array(); //регулярки для проверки переменных запроса

	private $controller;
	private $action;

	public $role = 0;

	public function __construct($method, $path, $callback) {
		$this->method = strtolower($method);
		//к пути добавляем корень приложения, например путь '/test', а корень '/root/app', будет /root/app/test
		$this->path = ROUTE_ROOT.$path;

		//получаем имя контроллера и имя метода, запрос к методу строится: контроллер:метод
		$partsCallback = explode(':', $callback);
		$controller = $partsCallback[0];

		//если передано имя метода то запомним его
		//иначе присвоим имя метода по-умолчанию
		if(isset($partsCallback[1])) {
			$this->action = $partsCallback[1];
		} else {
			$this->action = 'index';
		}

		//туду многократный вызов контроллера
		$this->controller = new $controller;

		//добавляем запрос в очередь
		Application::getInstance()->requests[] = $this;
	}

	/*
	 * Принимаем регулярку для части запроса, 
	 * $name должно соответствовать имени переменной в пути /{id}: $name = id.
	 * $req->assert('id', '|^[0-9]+$|')->run();
	 */
	public function assert($name, $re) {
		$this->asserts[$name] = $re;

		//продолжаем цепочку
		return $this;
	}

	public function isRole($id) {
		$this->role = $id;
	}

	/*
	 * Проверки корректности запроса и вызов кэллбека
	 */
	public function run() {

		//проверяем метод запроса
		if($this->method != '' && strtolower($_SERVER['REQUEST_METHOD']) != $this->method) {
			//header('Location:'.ROUTE_ROOT.'/errors?status=404');
			return false;
		}

		//переменные запроса для передачи в кэллбек
		$args = array();

		//разбиваем адрес и путь, к которому обратился пользователь
		$uri = explode('/', $_SERVER['REQUEST_URI']);
		$path = explode('/', $this->path);

		//если запрос пришел с GET параметрами, то выбрасываем их, путь должен быть чистым, они автоматически попадут в $_GET
		if(strpos(end($uri), '?') !== false){
			$query = explode('?', end($uri));
			$lastElemUri = array_pop($uri);
			$lastElemUri = $query[0];
			array_push($uri, $lastElemUri);
		}

		//Удаляем пустые элементы
		$uri = array_values(array_filter($uri, 'filter_empty_str'));
		$path = array_values(array_filter($path, 'filter_empty_str'));

		//если кол-во частей в массивах разное - выходим
		if(count($uri) != count($path)) {
			return false;
			//header('Location:'.APP_ROOT.'/errors?status=404');
		}

		//проходим по всем частям запроса
		for($i = 0; $i < count($path); $i++) {
			//проверяем часть пути, является ли переменной
			//переменные - оформляются в фигурные скобки
			if(preg_match('|^\{(.*)\}$|', $path[$i], $match)) {
				
				//есть ли регулярки для проверки пути
				if(!isset($this->asserts[$match[1]]) || preg_match($this->asserts[$match[1]], $uri[$i])) {
					//добавим эту переменную в массив
					$args[$match[1]] = $uri[$i];
				} else {
					return false;
					//header('Location:'.APP_ROOT.'/errors?status=404');
				}
			} else {
				//если часть не переменная, просто сравниваем часть URI с запросом
				if($uri[$i] != $path[$i]){
					return false;
					//header('Location:'.APP_ROOT.'/errors?status=404');
				}
			}
		}

		//вызываем кэллбек, передавая массив с переменными запроса
		if (!method_exists($this->controller, $this->action)) {
			//header('Location:'.APP_ROOT.'/errors?status=404');
			return false;
		} else {
			$action = $this->action;
			$controller = $this->controller;

			//вызов метода контроллера с параметрами из ключей массива
			//$reflectionMethod = new ReflectionMethod($controller, $action);
			//$result = $reflectionMethod->invokeArgs(new $controller(), $args);

			$result = call_user_func_array(array(new $controller, $action), $args);

			//$result = $controller->$action($args);
			//call_user_func_array($controller->$action, $args);
		}

		//$result =  call_user_func_array($this->callback, $args);

		if(is_bool($result))
			return $result;
		else
			return true;
	}
}
