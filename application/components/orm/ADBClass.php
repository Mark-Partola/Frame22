<?php

namespace Frame\Application\Components\Orm;

abstract class ADBClass{

	public function select($sql, $params=null){

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
			}

			$res = $stmt->fetchAll();
			if(count($res) === 1) $res = $res[0];

		} catch(\PDOException $e) {
			$res = false;
		}

		return $res;
	}

}
