<?php namespace Models\Application;


class Product extends \Models\Model_abstractDb{


	public function getLastProducts($limit){

		$res = $this->orm->select("SELECT `id`, `title`, `main_image` FROM `prefix_article` ORDER BY `create_at` DESC LIMIT ?", array((int)$limit));

		array_walk($res, function(&$item) {
			if(empty($item['main_image'])) unset($item['main_image']);
		});

		return $res;

	}

	public function getProductById($id){

		if(intval($id) == 0){
			$id = $this->orm->select("SELECT `id` FROM `prefix_article`
				WHERE `alias` = ?", array($id));
			$id = $id['id'];
		}

		$preRes = $this->orm->select("SELECT `a`.`title`, `a`.`content`, `p`.`prop_title`, `p`.`value`
					FROM `prefix_article` as `a`
						INNER JOIN `prefix_props` as `p`
							ON `a`.`id` = `p`.`id_elem`
					WHERE `p`.`id_elem` = ?", array($id));

		$res = array();

		if(!key_exists('title', $preRes)) {
			foreach($preRes as $key=>$val){
				$res['title'] = $val['title'];
				$res['content'] = $val['content'];
				$res['props'][$val['prop_title']] = $val['value'];
			}
		} else {
			$res['title'] = $preRes['title'];
			$res['content'] = $preRes['content'];
			$res['props'][$preRes['prop_title']] = $preRes['value'];
		}

		if(empty($res)) {
			$res = $this->orm->select("SELECT `title`, `main_image`, `id`, `content` FROM `prefix_article`
				WHERE `id` = ?", array($id));
		}

/*		array_walk($res, function(&$item) {
			if(!$item) unset($item);
		});*/

		return $res;

	}

	public function getAllPropsForElem($id){

		$idCat = $this->orm->select("SELECT `id_cats` 
										FROM  `prefix_articles_in_cats` 
											WHERE `id_article` = ?", array($id));

		$result = $this->getProps($idCat);
		//print_arr($result);

		$resultSet = array();

		foreach ($result as $value) {
			if(is_array($value)){
				$resultSet[] = $value[key($value)];
			} else{
				$resultSet[] = $value;
			}
		}

		//print_arr($resultSet);
		return $resultSet;

	}

	private function getPropsForCat($id){
		$uniqid = uniqid();
		$propSet = $this->orm->select("SELECT `prop` as `{$uniqid}`
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

	/**
	* Сохранение свойств с проверкой на существующие
	*/
	public function savePropsForElem($id, $props){

		// сначала удалим все имеющиеся свойства

		$sql = "DELETE FROM `prefix_props` WHERE `id_elem` = ?";

		$res = $this->orm->delete($sql, array($id));

		if($res !== '00000') {
			return false;
		}

		//добавляем новые свойства

		$sql = "INSERT INTO `prefix_props`(`prop_title`,`value`, `id_elem`)
					VALUES(?, ?, ?)";

		foreach($props as $key => $value) {
			$this->orm->insert($sql, array($key, $value ,$id));
		}

	}

	/**
	* Установка главного изабражения элемента
	*/
	public function saveMainImage($id, $src) {

		$sql = "UPDATE `prefix_article` SET `main_image` = ?
					WHERE `id` = ?";

		$res = $this->orm->update($sql, array($src, $id));

		echo $res;

	}

	/**
	* Изменение статуса элемента
	*/
	public function changeStatus($id, $status) {

		$sql = "UPDATE `prefix_article` SET `status` = ?
					WHERE `id` = ?";

		$res = $this->orm->update($sql, array($status, $id));

		echo $res;

	}

	/**
	* Выборка продуктов по фильтру
	*/
	public function getProductsByFilter($criteria) {

		$firstPartSQL = "SELECT `id`, `title`, `main_image` FROM `prefix_article`";
		$lastPartSQL = " ORDER BY `create_at` DESC";

		$detectWhere = false;
		$arguments = array();

		if(isset($criteria->priceRange)) {
			if(!$detectWhere) {
				$firstPartSQL .= " WHERE ";
				$detectWhere = true;
			}
			$firstPartSQL .= "`price` BETWEEN ? AND ?";
			array_push($arguments, $criteria->priceRange->from);
			array_push($arguments, $criteria->priceRange->to);
		}

		if(isset($criteria->title)) {
			if(!$detectWhere) {
				$firstPartSQL .= " WHERE ";
				$detectWhere = true;
			} else {
				$firstPartSQL .= ' AND ';
			}
			$firstPartSQL .= "`title` LIKE '%".$criteria->title."%'";
		}

		$sql = $firstPartSQL . $lastPartSQL;

		$res = $this->orm->select($sql, $arguments);

		if(!isset($res['main_image'])) {
			array_walk($res, function(&$item) {
				if(empty($item['main_image'])) unset($item['main_image']);
			});
		} else {
			if(empty($res['main_image'])) unset($res['main_image']);
		}


		//print_arr($res);
		//echo $sql;
		return $res;

	}


}