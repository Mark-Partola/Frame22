<?php namespace Controllers\Admin;

class Admin_index extends \Controllers\Ctrl_base{

	public function index(){

		if(!in_array(1, $_SESSION['auth']['action'])) header('Location: '.ROUTE_ROOT.'/auth/login');

		$template = $this->twig->loadTemplate('index.html');
		$title = 'Заголовок';

		echo $template->render(array(
			'title' => $title
		));

		//echo $this->getTemplate('default/admin/index');

	}
}