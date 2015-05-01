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

	public function getAllPropsForElem($id){

		$idCat = $this->orm->select("SELECT `id_cats` 
										FROM  `prefix_articles_in_cats` 
											WHERE `id_article` = ?", array($id));

		$result = $this->getProps($idCat);

		$resultSet = array();

		foreach ($result as $key=>$value) {
			if(is_array($value)){
				$resultSet[] = $value['prop'];
			} else{
				$resultSet[] = $value;
			}
		}

		print_arr($resultSet);
		//return $propSet;

	}

	private function getPropsForCat($id){

		$propSet = $this->orm->select("SELECT `prop` 
										FROM `prefix_props_in_cats`
											WHERE `id_cat` = ?", array($id));

		return $propSet;

	}

	private function getProps($id){

		if(array_key_exists('id_cats', $id)) {
			$idCat = $id['id_cats'];
		} elseif (array_key_exists('id_parent', $id)){
			$idCat = $id['id_parent'];
		} else {
			$idCat = null;
		}

		if($idCat){
			$res = $this->getPropsForCat($idCat);

			$idCat = $this->orm->select("SELECT `id_parent` 
										FROM `prefix_category`
											WHERE `id` = ?", array($idCat));
			$resultSet = array_merge($res, $this->getProps($idCat));
		} else {
			return array();
		}

		return $resultSet;

	}


}