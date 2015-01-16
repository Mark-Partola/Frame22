<?php
require 'Model_databaseConnect.php';

abstract class Model_abstractDb{

	protected $db;

	public function __construct() {
		$this->db = Model_databaseConnect::connect();
	}

	public function all(/*$query*/){
		$res = $this->db->query("SELECT * FROM `lib_books`");
		$rows = $res->fetchAll();
		/*print_arr($rows);*/

		return $rows;
	}

	public function filter($name, $mark, $value) {
		$stmt = $this->db->prepare("SELECT * FROM `lib_books` WHERE `$name` $mark ?");
		$stmt->execute(array($value));
		$rows = $stmt->fetch();
		/*print_arr($rows);*/

		return $rows;
	}

}