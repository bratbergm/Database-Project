<?php


/**
 * Class for skis. Generates JSON documents from the dbproject database 
 * 
 */

class OrderModel {

    protected $db;

    public function __construct() {
        $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8',
            DB_USER, DB_PWD,
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }

public function getSkis(): array {
    $res = $array();

    $query = "";
}













}