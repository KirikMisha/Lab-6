<?php
include __DIR__ . '/../database/Database.php';
include __DIR__ .'/../models/Product.php';
include __DIR__ . "/../DAO/ProductsDao.php";
include __DIR__ . "/../exceptionMessages/ExceptionMessage.php";

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $db = new Database();
  $db->connect();
  $connection = $db->getConnection();
  $dao = new ProductsDao($connection);
  $data = json_decode(file_get_contents("php://input"));
  $product = new ProductModel(NULL, $data->name, $data->price, $data->description);
  if ($dao->create($product)) {
    http_response_code(201);
    echo json_encode(array('message' => 'Товар добавлен'));
  } else {
    http_response_code(500);
    echo json_encode(array('message' => 'Продкут не добавлен, попробуй еще раз'));
  }
} else {
  http_response_code(405);
  echo json_encode(new ExceptionMessage("REQUEST_METHOD in not allowed", 405));
}
