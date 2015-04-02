<?php namespace Models\User;


class Users extends \Models\Model_abstractDb{

	/*
	* Выборка всех пользователей, также выбор общего их количества
	*/
	public function getAllUsers($offset, $limit){

		try{
			$sql = "SELECT `u`.*, `r`.`title` as `user_role` FROM `prefix_users` as `u`
										INNER JOIN `prefix_roles` as `r`
											ON `u`.`role` = `r`.`privileges`
										LIMIT :offset , :res";

			$stmt = $this->db->prepare($sql);

			if($offset == 1 || $offset == 0){
				$offset = 0;
			}else
				$offset = ($offset-1)*$limit;


			$stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
			$stmt->bindParam(':res', $limit, \PDO::PARAM_INT);

			$stmt->execute();

			$result = $stmt->fetchAll();

			$numRows = $this->db->query("SELECT count(*) as `count` FROM `prefix_users`")->fetch();

			$pages = ceil($numRows['count'] / $limit);

			$result['count'] = $pages;

			return $result;

		}catch(\Exception $e){

		}

	}

	public function getRoles(){
		try{
			$sql = "SELECT * FROM
						`prefix_roles`";

			return $this->db->query($sql)->fetchAll();

		}catch(\Exception $e){

		}
	}

	public function getActions(){
		try{
			$sql = "SELECT * FROM
						`prefix_actions`";

			return $this->db->query($sql)->fetchAll();

		}catch(\Exception $e){

		}
	}

	public function createUser($data){
		try{
			$sql = "INSERT INTO `prefix_users`(`login`, `password`, `fname`,`lname`, `email`,`role`)
						VALUES(:login, :password,:fname, :lname, :email, :role)";

			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(':login', $data->login, \PDO::PARAM_STR);
			$stmt->bindParam(':password', $data->pass, \PDO::PARAM_STR);
			$stmt->bindParam(':fname', $data->fname, \PDO::PARAM_STR);
			$stmt->bindParam(':lname', $data->lname, \PDO::PARAM_STR);
			$stmt->bindParam(':email', $data->email, \PDO::PARAM_STR);
			$stmt->bindParam(':role', $data->role, \PDO::PARAM_INT);

			$stmt->execute();

			if($stmt->rowCount())
				return array('title'=>'Пользователь создан!', 'status' => 1);

			return array('title'=>'Произошла ошибка!', 'status' => 0);

		}catch(\Exception $e){
			return array('title'=>'Произошла ошибка!', 'status' => 0);
		}
	}

	public function createRole($title, $actions){
		try{

			$maxPriv = $this->db->query("SELECT MAX(`privileges`) as `last_priv` FROM `prefix_roles`")->fetch();
			$maxPriv = $maxPriv['last_priv'] + 1;

			$stmt = $this->db->prepare("INSERT INTO `prefix_roles`(`title`, `privileges`)
						VALUES(:title, '$maxPriv')");
			$stmt->bindParam(':title', $title, \PDO::PARAM_STR);
			$stmt->execute();

			$lastId = $this->db->lastInsertId();

			foreach ($actions as $action) {
				$stmt = $this->db->prepare("INSERT INTO `prefix_privileges`(`id_role`, `action`)
						VALUES(:role, :action)");
				$stmt->bindValue(':role', $lastId, \PDO::PARAM_INT);
				$stmt->bindValue(':action', $action, \PDO::PARAM_INT);

				$stmt->execute();
			}

			return array('title'=>'Пользователь создан!', 'status' => 1);

		}catch(\Exception $e){
			return array('title'=>'Произошла ошибка!', 'status' => 0);
		}
	}


	/*контент*/

	public function getCategories() {

		$sql = "SELECT *
				FROM `prefix_category`
				WHERE `id_parent` = 0";

		$stmt = $this->db->query($sql);
		$result = $stmt->fetchAll();

		$endResult = array();

		foreach ($result as $item) {

			$rsChildren = $this->getChildrenForCat($item['id']);

			if($rsChildren) {
				$item['children'] = $rsChildren;
			}

			$endResult[] = $item;
		}

		return $endResult;

	}

	public function getChildrenForCat($id) {

		$sql = "SELECT *
				FROM `prefix_category`
				WHERE
				`id_parent` = $id";

		$stmt = $this->db->query($sql);
		$result = $stmt->fetchAll();

		$endResult = array();

		foreach ($result as $item) {

			$rsChildren = $this->getChildrenForCat($item['id']);

			if($rsChildren) {
				$item['children'] = $rsChildren;
			}

			$endResult[] = $item;
		}

		return $endResult;

	}


	/*
	*	Получаем идентификаторы категорий, в которых присутствуют элементы
	*/
	public function getCategoriesWithElems() {

		$sql = "SELECT DISTINCT(`id_cats`)
				FROM `prefix_articles_in_cats`";

		$stmt = $this->db->query($sql);

		$result = $stmt->fetchAll();

		$newResult = array();

		foreach ($result as $key => $value) {
			$newResult[] = $value['id_cats'];
		}

		return $newResult;
	}

	/*
	*	Получаем элементы по айди категории
	*/
	public function getElemsByCats($id) {

		$sql = "SELECT *
					FROM `prefix_articles_in_cats` as `cross`
					INNER JOIN `prefix_article` as `a`
						ON `cross`.`id_article` = `a`.`id`
							WHERE `cross`.`id_cats` = :id";

		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(':id', $id, \PDO::PARAM_INT);

		$stmt->execute();


		return $stmt->fetchAll();
	}

	/*
	*	Обновление заголовка и контента категории
	*/
	public function updateElem($id, $title, $content) {

		try{
			$sql = "UPDATE `prefix_article` 
						SET `title` = :title, `content` = :content
							WHERE `id` = :id";

			$stmt = $this->db->prepare($sql);

			$stmt->bindParam(':id', $id, \PDO::PARAM_INT);
			$stmt->bindParam(':title', $title, \PDO::PARAM_STR);
			$stmt->bindParam(':content', $content, \PDO::PARAM_STR);

			$stmt->execute();

			if($stmt->rowCount()){
				return array('title'=>'Успешно обновлено!', 'status' => 1);
			}

			return array('title'=>'Произошла ошибка!', 'status' => 0);

		}catch(\Exception $e){
			return array('title'=>'Произошла ошибка!', 'status' => 0);
		}

	}

}
