<?php namespace Models\Content;


class Category extends \Models\Model_abstractDb{


	public function getAllProps(){

		$sql = "SELECT * FROM `prefix_props`";

		$stmt = $this->db->query($sql);

		return $stmt->fetchAll();

	}

	public function getCategories(){

		$sql = "SELECT * FROM `prefix_category`";

		$stmt = $this->db->query($sql);

		return $stmt->fetchAll();

	}


}