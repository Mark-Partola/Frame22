<?php
require 'Model_databaseConnect.php';

abstract class Model_abstractDb{

	protected $db;

	public function __construct() {
		$this->db = Model_databaseConnect::connect();
	}

}