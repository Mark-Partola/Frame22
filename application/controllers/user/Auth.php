<?php namespace Controllers\User;

class Auth extends \Controllers\Ctrl_base{

	public function index(){

		$template = $this->twig->loadTemplate('default/login.html');

		echo $template->render(array(
			'dir' => ROUTE_ROOT
		));

	}

	public function login(){

		$model = new \Models\User\Auth();

		$authData = $model->login($_POST['login'], md5($_POST['password']));

		if(!$authData){
			header('Location: '.ROUTE_ROOT.'/auth/login');
		} else {
			$_SESSION['auth'] = $authData;

			header('Location: '.ROUTE_ROOT);
		}

	}
	public function logout(){
		unset($_SESSION['auth']);
		header('Location: '.ROUTE_ROOT);
	}
}