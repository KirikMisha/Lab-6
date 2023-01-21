<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');

include __DIR__ . '/../database/Database.php';
include __DIR__ . '/../exceptionMessages/ExceptionMessage.php';
include __DIR__ . '/../DAO/ProductsDao.php';

if ($_SERVER['REQUEST_METHOD'] == "DELETE") {

	$db = new Database();
	$db->connect();
	$connection = $db->getConnection();

	if (isset($_GET["id"])) {
		$id = (int) $_GET["id"];
		$dao = new ProductsDao($connection);
		$product = $dao->getById($id);
		if ($product != NULL) {
			$isDeleted = $dao->delete($id);
			if ($isDeleted) {
				http_response_code(200);
				echo json_encode(array('message' => 'Товар удален'));
			} else {
				http_response_code(500);
				echo json_encode(new ExceptionMessage("Internal Server Error", 500));
			}
		} else {
			http_response_code(404);
			echo json_encode(new ExceptionMessage("Product not found", 404));
		}
	} else {
		http_response_code(404);
		echo json_encode(new ExceptionMessage("Bad request", 400));
	}
} else {
	http_response_code(405);
	echo json_encode(new ExceptionMessage("REQUEST_METHOD in not allowed", 405));
}
