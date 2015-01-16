<?php

namespace Frame\Application\Components\Orm;

require_once "ORMException.php";

/* класс для работы с таблицей. Использует что-то похожее на ActiveRecord.
*  Использование:
*
*  1. Создаем новый экземпляр класса, передавая в конструктор объект PDO
*     $o = new ORM($pdo);
*  2. Загружаем таблицу
*     $o->setTable('lib_users');
*  3. Выбираем запись по id
*     $o->recover(2);
*  4. Выводим значение поля таблицы
*     echo $o->fname;
*  5. Устанавливаем новое значение поля
*     $o->email = 'email@example.com';
*  6. Сохраняеим изменения
*     $o->save();
*/

class ORM{

	private $pdo;
	private $table; // имя таблицы БД

	private $fields = array(); // массив с информацией о полях таблицы. Имя, значение, тип, новое значение.

	private $needUpdate; // состояние ожидания обновления


	public function __construct(\PDO $pdo){
		$this->pdo = $pdo;
	}

	/*Загрузка таблицы*/
	public function setTable($table=null){
		if(!is_string($table) && !is_null($table))
			throw new ORMException("Argument [table] must be [string | null]");

		$this->table = $table;
	}

	/*Получить результат в виде ассоциативного массива*/
	public function getRowAsArray($id){
		$sql = "SELECT * FROM `{$this->table}`";
		return $this->pdo->query($sql)->fetch();
	}

	/*Загрузка состояния записи в таблице. Выбираем запись по идентификатору. Все поля таблицы записываются в ассоциативный массив
	Также в массив добавляется информация о типе поля.*/
	public function recover($id){
		if(!is_integer($id))
			throw new ORMException("Argument [id] must be [integer]");

		$sql = "SELECT * FROM `{$this->table}`
					WHERE `id` = $id";
		$res = $this->pdo->query($sql);

		if(empty($res))
			throw new ORMException("Don`t isset field");

		$result = $res->fetch();
		for($i = 0; $i<count($result); $i++){
			$this->fields[key($result)]['type'] = $this->_translateNativeType($res->getColumnMeta($i)['native_type']);
			$this->fields[key($result)]['value'] = $result[key($result)];
			next($result);
		}
	}

	/*Получение свойства объекта. Свойство - отражение поля таблицы*/
	function __get($field){
		if(array_key_exists($field, $this->fields))
			return $this->fields[$field]['value'];
		else{
			throw new ORMException("Not Found property [".$field."]");
		}
	}

	/* Установление свойства объекта. Свойство - отражение поля таблицы. 
	*  После изменения свойства, объект меняет состояния на "ожидает обновления" ($needUpdate = true)
	*  Новое значение записывается в элемент 'new' свойства таблицы.
	*/

	function __set($field, $value){
		if(array_key_exists($field, $this->fields) && gettype($value) ===$this->fields[$field]['type']){
			$this->fields[$field]['new'] = $value;
			$this->needUpdate = true;
		}
		else{
			throw new ORMException("Don`t rewrite property [".$field."]");
		}
	}

	/*Сохранение состояния объекта, строит update-запрос к БД*/

	public function save(){

		echo '<pre>'.print_r($this->fields,true).'</pre>';

		if(!$this->needUpdate)
			return false;

		$sql = "UPDATE `{$this->table}` (";

		foreach($this->fields as $key => $val){
			if(isset($this->fields[$key]['new'])){
				$sql .= "`{$key}`, ";
			}
		}

		$sql = substr($sql, 0, -2);
		$sql .= ') SET (';

		foreach($this->fields as $key => $val){
			if(isset($this->fields[$key]['new'])){
				if($this->fields[$key]['type'] === 'string')
					$sql .= "'{$this->fields[$key]['new']}', ";
				else
					$sql .= $this->fields[$key]['new'].', ';
			}
		}

		$sql = substr($sql, 0, -2);
		$sql .= ')';
		echo $sql;
	}

	/*Преобразует вывод метода PDO::getColumnMeta в вид удобный для использования в подготовленных запросах*/

	private function _translateNativeType($orig) {
	    $trans = array(
	        'VAR_STRING' => 'string',
	        'STRING' => 'string',
	        'BLOB' => 'string',
	        'LONGLONG' => 'integer',
	        'LONG' => 'integer',
	        'SHORT' => 'integer',
	        'DATETIME' => 'string',
	        'DATE' => 'string',
	        'DOUBLE' => 'integer',
	        'TIMESTAMP' => 'string',
	        'TINY' => 'integer'
	    );
	    return $trans[$orig];
	}

}

try{

	$pdo = new \PDO("mysql:host=localhost;dbname=library", 'root', '123');
	$pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

	$o = new ORM($pdo);

	$o->setTable('lib_users');
	$o->recover(2);
	//echo $o->fname;
	$o->email = 'qwer@qwe.eeee';
	//$o->fname = 'qeeee';
	$o->id = 10;
	$o->save();
}catch(ORMException $e){

	echo $e->getMessage();

}