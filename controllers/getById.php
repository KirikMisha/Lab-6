<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include  __DIR__ . "/../database/Database.php";
    include __DIR__ . "/../DAO/ProductsDao.php";
    include __DIR__ . "/../exceptionMessages/ExceptionMessage.php";

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $db = new Database();
        $db->connect();
        $connection = $db->getConnection();

        if(isset($_GET["id"])){

            $id = (int) $_GET["id"];
            $dao = new ProductsDao($connection);
                $product = $dao->getById($id);
                if($product != NULL) {
                    echo json_encode($product);
    
                } else {
                    http_response_code(404);
                    echo json_encode(new ExceptionMessage("Poduct not found", 404));
                }

        }
     else {
        http_response_code(404);
            echo json_encode(new ExceptionMessage("Bad request", 400));
        }
    }else {
        http_response_code(405);
        echo json_encode(new ExceptionMessage("REQUEST_METHOD in not allowed", 405));
    }