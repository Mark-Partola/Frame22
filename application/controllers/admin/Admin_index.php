<?php namespace Controllers\Admin;

class Admin_index extends \Controllers\Ctrl_base{

	private function getUserData($id){
		$model = new \Models\Model_index();
		return $model->getUserData($id);
	}

	private function getAllUsers(){
		$offset = 0;
		$limit = 5;
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
	private function getActions(){
		$model = new \Models\User\Users();
		return $model->getActions();
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
			$args['actions'] = $this->getActions();
		}

		echo $template->render($args);

	}

	public function createUser(){
		$raw = file_get_contents('php://input');
		if ( $raw ) {
			$decode = json_decode($raw);
		}

		$model = new \Models\User\Users();

		echo json_encode($model->createUser($decode));
	}
}