<?php namespace Controllers\Admin;

class Admin_index extends \Controllers\Ctrl_base{

	private function getUserData($id){
		$model = new \Models\Model_index();
		return $model->getUserData($id);
	}

	private function getAllUsers(){
		$offset = 0;
		$limit = 5;
		if(isset($_GET['offset']))
			$offset = $_GET['offset'];

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

	/*контент*/
	private function getCategoriesTree(){
		$model = new \Models\User\Users();
		return $model->getCategories();
	}
	private function getCategories(){
		$model = new \Models\Content\Category();
		return $model->getCategories();
	}

	private function getCategoriesWithElems(){
		$model = new \Models\User\Users();
		return $model->getCategoriesWithElems();
	}

	private function getElemsByCats(){
		$model = new \Models\User\Users();
		if(isset($_GET['catId']))
			$id = $_GET['catId'];
		return $model->getElemsByCats($id);
	}

	private function getAllProps(){
		$model = new \Models\Content\Category();
		return $model->getAllProps();
	}
	/*Элементы*/
	private function getAllElems(){

		$offset = 0;
		$limit = 5;
		if(isset($_GET['offset']))
			$offset = $_GET['offset'];

		$model = new \Models\Content\Category();
		return $model->getAllElems($offset, $limit);
		return $allUsers;
	}
	private function countAllElems(){
		$model = new \Models\Content\Category();
		return $model->countAllElems();
	}


	/*конец контента*/

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


		if($content == 'users'){
			$arrayUsers = $this->getAllUsers();
			$countAllUsers = array_pop($arrayUsers);
			$args['users'] = $arrayUsers;
			$args['countUsers'] = $countAllUsers;
			$args['roles'] = $this->getRoles();
			$args['actions'] = $this->getActions();
		}
		elseif($content == 'categories'){
			$arrayUsers = $this->getAllUsers();
			$countAllUsers = array_pop($arrayUsers);
			$args['treeCats'] = $this->getCategoriesTree();
			$args['catsWithElems'] = $this->getCategoriesWithElems();
			$args['countElems'] = $countAllUsers;
		}
		elseif($content == 'content'){
			$args['properties'] = $this->getAllProps();
			$args['cats'] = $this->getCategories();
		}
		elseif($content == 'elems'){
			$args['elems'] = $this->getElemsByCats();
		}
		elseif($content == 'allElems'){
			$args['elems'] = $this->getAllElems();
			$args['count'] = $this->countAllElems();
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

	public function createAction(){
		$raw = file_get_contents('php://input');
		if ( $raw ) {
			$decode = json_decode($raw);
		}

		$model = new \Models\User\Users();

		echo json_encode($model->createRole($decode->title, $decode->ids));
	}

	public function updateElem($id){
		$model = new \Models\User\Users();
		echo json_encode($model->updateElem($id, $_POST['title'], $_POST['content']));
	}
}