<?php namespace Controllers\Admin;

class Admin_index extends \Controllers\Ctrl_base{

	public function index(){

		if($_SESSION['role'] !== 'admin' || !$_SESSION['priv']['show_admin']) header('Location: '.ROUTE_ROOT.'/auth/login');

		echo 'Hello Admin!';

	}
}