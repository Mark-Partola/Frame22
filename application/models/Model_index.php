<?php namespace Models;

class Model_index extends Model_abstractDb{

	public function testORM(){

		try{
			echo '<pre>'.print_r($this->orm->select("SELECT * FROM `prefix_users` WHERE `id` = ? OR `id` = ?", array(1, 3)),true).'</pre>';
			$this->orm->setTable('prefix_users');
			$this->orm->recover(1);
			echo $this->orm->email;
			//$this->orm->email = 'g@qwe.eeee';
			//$o->id = 10;
			//$o->save();
		}catch(ORMException $e){

			echo $e->getMessage();

		}
	}

}