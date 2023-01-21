<?php

class ExceptionMessage{

    private $message;

    private $statusCode;

    public function __construct($message, $statusCode){
        $this->message = $message;
        $this->statusCode = $statusCode;
    }
}