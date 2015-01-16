<?php

namespace Frame\Application\Components;

class Entity{

	private $table;
	private $id;

	public function __construct($table, $id){
		$this->table = $table;
		$this->id = $id;
	}

}