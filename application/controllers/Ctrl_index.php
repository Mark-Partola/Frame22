<?php

require  __DIR__."/../models/Model_index.php";

class Ctrl_index extends Ctrl_base{


	public function index(){

		$this->model = new Model_index();

		$this->model->testORM();

	}
}