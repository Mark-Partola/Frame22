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

			$offset = (int)$offset;

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

}