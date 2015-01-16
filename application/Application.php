<?php

class Application {

	public $requests = array();
	public static $registered_path = array();

	protected static $instance;

	private function __construct() {}
	private function __clone() {}
	private function __wakeup() {}

	public static function getInstance() {

		if(!is_object(self::$instance)) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public static function init() {
		require_once __DIR__.'/bootstrap.php';
		self::getInstance();
	}

	//метод обработки всех запросов за один раз
	private function i_run() {
		$i = 1;
		foreach($this->requests as &$request) {
			self::$registered_path[] = $request->path;

			if(isset($_SESSION['user']['role']) && ($request->role !== 0) && ($request->role != $_SESSION['user']['role'])) continue;

			$done = $request->run();

			if($done) {
				RequestLogger::log('Request',$_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
				return true;
			} else {
				$path = $_SERVER['REQUEST_URI'];
			 }
		}
		RequestLogger::log('Request',($_SERVER['REQUEST_METHOD']), $path);

		header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); 
		header('Location:'.ROUTE_ROOT.'/errors?status=404');
	}

	public static function run() {
		Request('GET', '/errors','Ctrl_index:err');
		return Application::getInstance()->i_run();
	}

	public static function triggerError($status = 1000){
		$_GET['status'] = $status;
		include(DOCUMENT_ROOT.'/public/tpl/errors/error.php');
		exit;
	}

}

class Logger{

	protected static $active = ACTIVE_LOGGER;

	public function all($message, $file=null, $line=null){

		$arr = array();

		$arr[] = date("F-j-Y g:i:s a",time()) . "\t|\t";
		$arr[] = $message . "\t\t|\t";
		//$arr[] = 'File = '.$file . "\t\t\t|\t";
		//$arr[] = 'Line = '.$line . "\t\n";

		return $arr;

	}
}

class RequestLogger extends Logger{
	public static function log($message, $method, $path){

		if(!self::$active) return false;

		$arr = parent::all($message);
		$arr[] = $method."\t|\t";
		$arr[] = $path."\t|\t";
		$arr[] = $_SERVER['REMOTE_ADDR']."\t|\t";


		//file_put_contents(DOCUMENT_ROOT.'/application/logs/request.log', $path."\n", FILE_APPEND);
		//print_arr($arr);

		if(in_array($path, Application::$registered_path)){
			//echo $path;
			//print_arr(Application::$registered_path);
			$_SESSION['status'] = 200;
			$_SESSION['path'] = $path;

			file_put_contents(DOCUMENT_ROOT.'/application/logs/request.log', $arr, FILE_APPEND);
			RequestLogger::appendStatus($_SESSION['status']);
		} else {
			//file_put_contents(DOCUMENT_ROOT.'/application/logs/request.log', $path."\n", FILE_APPEND);
				//$_SESSION['path'] = $path;
			//$_SESSION['status'] = 200;
			
			if(!(stripos($path, 'errors') !== false)){
				$_SESSION['path'] = $path;
				$arr[3] = $_SESSION['path']."\t|\t";
				file_put_contents(DOCUMENT_ROOT.'/application/logs/request.log', $arr, FILE_APPEND);
				$_SESSION['doneInfoLog'] = true;
			} else {
				preg_match('/\d{3,4}/',$path, $status);
				$_SESSION['status'] = $status[0];
				
				if($_SESSION['doneInfoLog']){
					RequestLogger::appendStatus($_SESSION['status']);
					$_SESSION['doneInfoLog'] = false;
				}
			}

		}

		//$arr[3] = $_SESSION['path']."\t|\t";
	}
	public static function appendStatus($status){

		if(!self::$active) return false;

		$status = $status."\n";
		file_put_contents(DOCUMENT_ROOT.'/application/logs/request.log', $status, FILE_APPEND);
	}
}