<?php namespace Controllers;


abstract class Ctrl_base {

	protected $template;

	/*
	* Метод генерации шаблона, 
	* подключается шаблон и передаются переменные,
	* генерируемые циклом. Ключи ассоциативного массива
	* становятся именем переменной.
	* Пример использования:
	*	$this->generateTemplate('index', 
	*			array('title' => 'заголовок', 'content' => $content));
	*/
	protected function generateTemplate($tplname, $vars = array()) {

		foreach ($vars as $key => $value) {
			$$key = $value;
		}

		ob_start();
			include 'tpl/'.$tplname.'.php';
		return ob_get_clean();

	}

	protected function getTemplate($page='index', $params=null, $title=SITE_NAME, $header='header', $footer='footer'){

		$header = $this->generateTemplate('header', array('title' => $title));
		$footer = $this->generateTemplate('footer');

		if(is_array($params)) {
			//print_arr($params);
			//fixed multi args
			$this->template = $this->generateTemplate($page, array('header' => $header, 'footer' => $footer, key($params) => $params[key($params)]));
		} else {
			$this->template = $this->generateTemplate($page, array('header' => $header, 'footer' => $footer));
		}

		return $this->template;
	}
}