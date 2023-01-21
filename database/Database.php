<?php

class Database {
    private $host = "localhost";
    private $user = "root";
    private $db = "misha_lab";
    private $pwd = "";
    private $connection = NULL;

    public function connect() {

        try{
            $this->connection = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pwd);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exp) {
            echo "Connection Error: " . $exp->getMessage();
        }
    }

    public function getConnection(){
        return $this->connection;
    }
}