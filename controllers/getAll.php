<?php

    include __DIR__ . "/../database/Database.php";
    include __DIR__ . "/../models/Product.php";
    include __DIR__ . "/../DAO/ProductsDao.php";
    include __DIR__ . "/../exceptionMessages/ExceptionMessage.php";

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $db = new Database();
        $db->connect();
        $connection = $db->getConnection();
        $dao = new ProductsDao($connection);

        echo json_encode($dao->getAll());

    } else {
        http_response_code(405);
        echo json_encode(new ExceptionMessage("REQUEST_METHOD in not allowed", 405));
    }