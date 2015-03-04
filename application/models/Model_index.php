<?php
require 'Model_abstractDb.php';

use Frame\Application\Components\Orm\ORM;

class Model_index extends Model_abstractDb{

	public function testORM(){

		try{
			$o = new ORM($this->db);
			echo '<pre>'.print_r($o->select("SELECT * FROM `lib_users` WHERE `id` = ? OR `id` = ?", array(1, 3)),true).'</pre>';
			$o->setTable('lib_users');
			$o->recover(3);
			echo $o->fname;
			//$o->email = 'g@qwe.eeee';
			//$o->id = 10;
			//$o->save();
		}catch(ORMException $e){

			echo $e->getMessage();

		}
	}

}