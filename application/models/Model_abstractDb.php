<?php namespace Models;

use Components\Orm\ORM;

abstract class Model_abstractDb{

	protected $db;

	public function __construct() {
		$this->db = Model_databaseConnect::connect();
		$this->orm = new ORM($this->db);
	}

}