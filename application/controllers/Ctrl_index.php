<?php namespace Controllers;

use Models\Model_index;

class Ctrl_index extends Ctrl_base{


	public function index(){
		$this->model = new Model_index();

		$this->model->testORM();

		print_arr($_SESSION);

		echo "<h1><a href=".ROUTE_ROOT.'/admin'.">Админка</a></h1>";

	}
}