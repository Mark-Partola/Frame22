<?php

namespace Components\Orm;

abstract class ADBClass{

	private function prepare($sql, $params=null){

		try {
			if(is_null($params)) {
				$stmt = $this->pdo->query($sql);
				if(!is_object($stmt))
					throw new \PDOException("Error Query");
			} else {
				$stmt = $this->pdo->prepare($sql);

				foreach ($params as $key => $value) {
					if(gettype($value) === 'integer')
						$stmt->bindValue($key+1, $value, \PDO::PARAM_INT);
					else
						$stmt->bindValue($key+1, $value, \PDO::PARAM_STR);
				}

				$stmt->execute();

				return $stmt;
			}

		} catch(\PDOException $e) {
			return false;
		}
	}

	public function delete($sql, $params=null){

		$stmt = $this->prepare($sql, $params);

		return $this->pdo->errorCode();

	}

	public function insert($sql, $params=null){

		$stmt = $this->prepare($sql, $params);

		return $this->pdo->lastInsertId();

	}

	public function update($sql, $params=null){

		$stmt = $this->prepare($sql, $params);

		return $this->pdo->errorCode();

	}

	public function select($sql, $params=null){

		$stmt = $this->prepare($sql, $params);

		$res = $stmt->fetchAll();
		if(count($res) === 1) $res = $res[0];

		return $res;

	}

}
