<?php

require_once "db/dbCredentials.php";

class PDOorders
{
    protected $db;

    public function __construct(){
        $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8',
            DB_USER, DB_PWD,
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }



    // Get all orders
    public function runFetchAllQuery() { // :array
        $stmt = $this->db->query("SELECT number, totalPrice, state FROM `order`");
     
      
         return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Get orders based on state
    public function runFetchOrdersState(string $state) {
        $stmt = $this->db->prepare("SELECT number, totalPrice, state FROM `order` WHERE state = :state");
        $stmt->bindValue('state', $state);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Changing the state of an order from new to open after reviewing it
    // 1. retreive an order based on order.number 
    // 2. update that order's state to open
    // Bind values that comes from the user
    public function runUpdateOrderState(int $number, string $state, bool $inTransaction = false) {

        if (!$inTransaction) {
            $this->db->beginTransaction();
        }

        $stmt = $this->db->prepare("SELECT number, totalPrice, state FROM `order` WHERE number = :number");
        $stmt->bindValue(':number', $number);
        $stmt->execute();

        
        //Check if the order number exists
        if ($stmt->fetch(PDO::FETCH_NUM)[0] == 0) {
            echo "Order Number does not exist";
            return;
        }
        

        $stmt = $this->db->prepare("UPDATE `order` SET state = :state WHERE number = :number");
        $stmt->bindValue(':number', $number);
        $stmt->bindValue(':state', $state);
        $stmt->execute();

        if (!$inTransaction) {
            $this->db->commit();
        }


    }



}