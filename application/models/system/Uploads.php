<?php namespace Models\System;


class Uploads extends \Models\Model_abstractDb{

	private $file_root;
	private $folder_imgs;


	public function __construct() {
		$this->file_root = ROUTE_ROOT.'/uploads/imgs/';
		$this->folder_imgs = $_SERVER['DOCUMENT_ROOT'] . ROUTE_ROOT.'/uploads/imgs';
	}

	public function getAllImages() {
		$result = array();
		foreach (scandir($this->folder_imgs) as $v){
			if ($v == '.' || $v == '..') continue;
			$result[] = $this->file_root . $v;
		}

		return $result;

	}


}