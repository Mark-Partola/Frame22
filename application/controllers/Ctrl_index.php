<?php namespace Controllers;

use Models\Model_index;

class Ctrl_index extends Ctrl_base{


	public function index(){

		$this->model = new Model_index();

		$this->model->testORM();

	}
}