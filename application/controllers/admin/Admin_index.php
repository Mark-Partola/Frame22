<?php namespace Controllers\Admin;

class Admin_index extends \Controllers\Ctrl_base{

	public function index(){

		if(!in_array(1, $_SESSION['auth']['action'])) header('Location: '.ROUTE_ROOT.'/auth/login');

		$template = $this->twig->loadTemplate('default/admin/index.html');

		echo $template->render(array(
			'dir' => ROUTE_ROOT
		));

		//echo $this->getTemplate('default/admin/index');

	}
}