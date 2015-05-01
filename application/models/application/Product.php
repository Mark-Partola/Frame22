<?php namespace Models\Application;


class Product extends \Models\Model_abstractDb{


	public function getLastProducts($limit){

		$stmt = $this->db->query("SELECT * FROM `prefix_article`");

		return $stmt->fetchAll();

	}

	public function getProductById($id){

		if(intval($id) == 0){
			$id = $this->orm->select("SELECT `id` FROM `prefix_article`
				WHERE `alias` = ?", array($id));
			$id = $id['id'];
		}

		$preRes = $this->orm->select("SELECT `a`.`title`, `a`.`content`, `p`.`prop_title`, `v`.`value`
					FROM `prefix_article` as `a`
						INNER JOIN `prefix_props` as `p`
							ON `a`.`id` = `p`.`id_elem`
						INNER JOIN `prefix_props_value` as `v`
							ON `p`.`id` = `v`.`id_props`
					WHERE `p`.`id_elem` = ?", array($id));

		$res = array();

		foreach($preRes as $key=>$val){
			$res['title'] = $val['title'];
			$res['content'] = $val['content'];
			$res['props'][$val['prop_title']] = $val['value'];
		}

		return $res;


	}


}