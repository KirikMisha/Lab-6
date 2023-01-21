<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');

include __DIR__ . '/../database/Database.php';
include __DIR__ . '/../models/Product.php';
include __DIR__ . "/../DAO/ProductsDao.php";
include __DIR__ . "/../exceptionMessages/ExceptionMessage.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$db = new Database();
	$db->connect();
	$connection = $db->getConnection();
	$dao = new ProductsDao($connection);

	$data = json_decode(file_get_contents("php://input"));

	if($data->id != NULL){
		$product = new ProductModel($data->id, $data->name, $data->price, $data->description);
		
	} else {
		http_response_code(400);
		echo json_encode(new ExceptionMessage("Bad request", 400));
	}
	if($dao->update($product)){
		http_response_code(200);
		echo json_encode(array('message' => 'Продукт обновлён'));
	} else {
		http_response_code(400);
		echo json_encode(new ExceptionMessage("Bad request", 400));
	}
} else {
	http_response_code(405);
	echo json_encode(new ExceptionMessage("REQUEST_METHOD in not allowed", 405));
}
