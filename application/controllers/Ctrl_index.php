<?php namespace Controllers;

use Models\Model_index;

class Ctrl_index extends Ctrl_base{


	public function index(){

		echo $this->generateTemplate('templates/app/index.html');

	}
}