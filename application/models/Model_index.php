<?php namespace Models;

class Model_index extends Model_abstractDb{

	public function testORM(){

		try{
			echo '<pre>'.print_r($this->orm->select("SELECT * FROM `lib_users` WHERE `id` = ? OR `id` = ?", array(1, 3)),true).'</pre>';
			$this->orm->setTable('lib_users');
			$this->orm->recover(3);
			echo $this->orm->fname;
			//$this->orm->email = 'g@qwe.eeee';
			//$o->id = 10;
			//$o->save();
		}catch(ORMException $e){

			echo $e->getMessage();

		}
	}

}