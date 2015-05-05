<?php namespace Controllers\Application;


class ProductsController extends \Controllers\Ctrl_base{


	public function getAllProducts(){

		header('Content-Type: text/json');
		$model = new \Models\Application\Product;
		echo json_encode($model->getLastProducts(9));

	}

	public function getProductById($id){

		header('Content-Type: application/json');
		$model = new \Models\Application\Product;
		//print_arr($model->getProductById($id));
		echo json_encode($model->getProductById($id));

	}

	public function getAllPropsForElem($id){
		$model = new \Models\Application\Product;
		echo json_encode($model->getAllPropsForElem($id));
	}

	public function savePropsForElem($id){
		$model = new \Models\Application\Product;
		$model->savePropsForElem($id, $_POST);
		echo json_encode(["title" => 'Хорошо', "status"=>'1']);
	}

	public function saveMainImage($id){
		$model = new \Models\Application\Product;
		$model->saveMainImage($id, $_POST['src']);
		//echo json_encode(["title" => 'Хорошо', "status"=>'1']);
	}

}