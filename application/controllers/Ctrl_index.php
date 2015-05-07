<?php namespace Controllers;

use Models\Model_index;

class Ctrl_index extends Ctrl_base{


	public function index(){

		$template = $this->twig->loadTemplate('app/index.html');

		$args = array(
			'dir' => ROUTE_ROOT
		);

		echo $template->render($args);

	}

	public function getCats(){

		$template = $this->twig->loadTemplate('app/cats.html');

		$catsTree = new \Models\User\Users();

		$args = array(
			'dir' => ROUTE_ROOT,
			'treeCats' => $catsTree->getCategories()
		);

		echo $template->render($args);

	}
}