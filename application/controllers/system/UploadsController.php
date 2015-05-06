<?php namespace Controllers\System;


class UploadsController extends \Controllers\Ctrl_base{


	public function getAllImages(){

		header('Content-Type: application/json');
		$model = new \Models\System\Uploads;
		echo json_encode($model->getAllImages());

	}

}