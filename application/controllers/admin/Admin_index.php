<?php namespace Controllers\Admin;

class Admin_index extends \Controllers\Ctrl_base{

	private function getUserData($id){
		$model = new \Models\Model_index();
		return $model->getUserData($id);
	}

	private function getAllUsers(){
		$offset = 0;
		$limit = 2;
		if(isset($_GET['usersOffset']))
			$offset = $_GET['usersOffset'];

		$model = new \Models\User\Users();
		$allUsers = $model->getAllUsers($offset, $limit);
		return $allUsers;
	}

	private function getRoles(){
		$model = new \Models\User\Users();
		return $model->getRoles();
	}

	public function index(){

		if(!in_array(1, $_SESSION['auth']['action'])) header('Location: '.ROUTE_ROOT.'/auth/login');

		$template = $this->twig->loadTemplate('default/admin/index.html');

		echo $template->render(array(
			'dir' => ROUTE_ROOT,
			'userData' => $this->getUserData($_SESSION['auth']['id'])
		));

	}

	public function getContent($content){
		if(!in_array(1, $_SESSION['auth']['action'])) header('Location: '.ROUTE_ROOT.'/auth/login');
		$request = false;
		if(isAjax())
			$request = true;

		$template = $this->twig->loadTemplate('default/admin/'.$content.'.html');

		$args = array(
			'dir' => ROUTE_ROOT,
			'request' => $request,
			'userData' => $this->getUserData($_SESSION['auth']['id'])
		);

		$arrayUsers = $this->getAllUsers();
		$countAllUsers = array_pop($arrayUsers);

		if($content == 'users'){
			$args['users'] = $arrayUsers;
			$args['countUsers'] = $countAllUsers;
			$args['roles'] = $this->getRoles();
		}

		echo $template->render($args);

	}
}