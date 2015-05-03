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

	public function getAllElems($offset, $limit){

		if($offset == 1 || $offset == 0){
			$offset = 0;
		}else
			$offset = ($offset-1)*$limit;

		$sql = "SELECT * FROM `prefix_article` LIMIT ?, ?";

		return $this->orm->select($sql, array($offset, $limit));

	}

	public function countAllElems(){

		$sql = "SELECT count(`id`) as `q` FROM `prefix_article`";

		$stmt = $this->db->query($sql);

		$res = $stmt->fetch();

		return ceil($res['q'] / 5);

	}


}