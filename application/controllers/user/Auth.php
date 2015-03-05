<?php namespace Controllers\User;

class Auth extends \Controllers\Ctrl_base{

	public function index(){

		echo $this->generateTemplate('default/login');

	}

	public function login(){

		$model = new \Models\User\Auth();

		$authData = $model->login($_POST['login'], md5($_POST['password']));

		if(!$authData) header('Location: '.ROUTE_ROOT.'/auth/login');


		$_SESSION['auth'] = $authData;

	}
}