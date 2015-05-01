<?php namespace Controllers\Application;


class ProductsController extends \Controllers\Ctrl_base{


	public function getAllProducts(){

		header('Content-Type: text/json');
		$model = new \Models\Application\Product;
		echo json_encode($model->getLastProducts(9));

	}

	public function getProductById($id){

		header('Content-Type: text/json');
		$model = new \Models\Application\Product;
		print_arr($model->getProductById($id));
		//echo json_encode($model->getProductById($id));

	}

}