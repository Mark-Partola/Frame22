<?php namespace Models\User;

use Components\Auth\Com_Auth;

class Auth extends \Models\Model_abstractDb{

	public function login($login, $password){

		$auth = new Com_Auth($login, $password, $this->db);

		$authData = $auth->checkAuth();

		$resultArray = array();
		foreach ($authData as $value) {
			$resultArray['id'] = $value['id'];
			$resultArray['role'] = $value['role'];
			$resultArray['action'][] = $value['action'];
			$resultArray['title'][] = $value['title'];
		}

		return $resultArray;

	}

}