<?php

use phpDocumentor\Reflection\DocBlock\Tags\Factory\StaticMethod;

require_once "dbCredentials.php";

/**
 * Class Orders for accessing order data in the dbproject database 
 */
class OrderModel {

    protected $db;

    public function __construct() {
        $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8',
            DB_USER, DB_PWD,
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }

/**
 * Returns basic information on all orders. (getCollection)
 */
    public function getOrders(): array {
        $res = array();

        $query = "SELECT number, totalPrice, state FROM `order`";

        $stmt = $this->db->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pos = count($res);
            $res[] = array();

            $res[$pos]['number'] = $row['number'];
            $res[$pos]['totalPrice'] = $row['totalPrice'];
            $res[$pos]['state'] = $row['state'];
        }
        return $res;
    }

    public function createOrdersDoc(): string {
        return json_encode($this->getOrders());
    }


/**
 * Returns orders based on state.
 * With all information on items in the order
 */
    public function getOrdersState(string $state) {
        $res = array();
        $stmt = $this->db->prepare("SELECT number AS orderNumber, totalPrice, 
        state FROM `order` 
        WHERE state = :state");
        
        $stmt->bindValue('state', $state);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pos = count($res);
            $res[] = array();

            $res[$pos]['orderNumber'] = $row['orderNumber'];
            $res[$pos]['totalPrice'] = $row['totalPrice'];
            $res[$pos]['state'] = $row['state'];

            $res[$pos]['Items'] = $this->getItemsForOrder($row['orderNumber']);
        }
        return $res;
    }

/**
 * Returns an order based on order number
 * With all information on items in the order
 */

// Orders
    public function getOrderWithItems(int $number): array {
        $res = array();

        $stmt = $this->db->prepare("SELECT number AS orderNumber, totalPrice, state FROM `order` WHERE number = :number");
        $stmt->bindValue(':number', $number);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pos = count($res);
            $res[] = array();

            $res[$pos]['orderNumber'] = $row['orderNumber'];
            $res[$pos]['totalPrice'] = $row['totalPrice'];
            $res[$pos]['state'] = $row['state'];

            $res[$pos]['Items'] = $this->getItemsForOrder($row['orderNumber']);
        }
        return $res;
    }
  
// Items
    public function getItemsForOrder(int $orderNumber) {
        $res = array();

        $query = "SELECT order_number, ski_pnr
        FROM orderitems
        WHERE order_number = :order_number";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':order_number', $orderNumber);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pos = count($res);
            $res[$pos]['ski_pnr'] = $this->getSkisForItems($row['ski_pnr']);
        }
        return $res;
    }

// Skitypes and skis
    public function getSkisForItems(int $itemNr) {
        $res = array();

        $query = "SELECT pnr, ski.type, ski.model, ski.temperature, ski.size, ski.weightClass, ski.gripSystem, ski.productionDate, skitype.type, skitype.typeOfSkiing, skitype.descripton, skitype.historical, skitype.msrp
        FROM ski
        INNER JOIN skitype ON skitype.model = ski.model 
        WHERE pnr = :pnr";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':pnr', $itemNr);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pos = count($res);
            $res[] = $row;
        }
        return $res;
    }


/**
 * Changing the state of an order from new to open after reviewing it
 * 1. retreive an order based on order.number
 * 2. update that order's state to open
 * Bind values that comes from the user
 * Updates state to value in uri[2], for the order with order number value in uri[1]
 * TO DO:
 *  - Check if input from user is new, open or skis avalable 
 */
    public function UpdateOrderState(int $number, string $state, bool $inTransaction = false) {

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

        $stmt = $this->db->prepare("SELECT number, totalPrice, state FROM `order` WHERE number = :number");
        $stmt->bindValue(':number', $number);
        $stmt->execute();
    }




/**
 * Add a new order. I am currently working/struggling with this.
 */
    
    public function createResource(array $resource, bool $inTransaction = false) {
        if (!$inTransaction) {
            $this->db->beginTransaction();
        }

        $res = array();

        $stmt = $this->db->prepare('INSERT INTO order
        (number, totalPrice, offLargeOrder, state, customerId)'
        . ' VALUES(:number, :totalPrice, :offLargeOrder, :state, :customerId)');
        $stmt->bindValue(':number', $resource['number']);
        $stmt->bindValue(':totalPrice', $resource['totalPrice']); // Må regnes ut et sted. Flytt msrp til ski?
        $stmt->bindValue(':offLargOrder', $resource['offLargeOrder']);
        $stmt->bindValue(':state', $resource['state']);
        $stmt->bindValue(':customerId', $resource['customerId']);
        $stmt->execute();

        $res['number'] = intval($this->db->lastInsertId());
        $res['totalPrice'] = $resource['totalPrice'];
        $res['offLargeOrder'] = $resource['offLargeOrder'];
        $res['state'] = $resource['state'];
        $res['customerId'] = $resource['customerId'];


        if (!$inTransaction) {
            $this->db->commit();
        }

    }

/*
    public function createResource(int $number, int $totalPrice, string $offLargeOrder, string $state, int $customerId, bool $inTransaction = false) {
        if (!$inTransaction) {
            $this->db->beginTransaction();
        }

        $stmt = $this->db->prepare('INSERT INTO order (number, totalPrice, offLargeOrder, state, customerId) VALUES(:number, :totalPrice, :offLargeOrder, :state, :customerId)');
        $stmt->bindValue('number', $number);
        $stmt->bindValue('totalPrice', $totalPrice);
        $stmt->bindValue('offLargeOrder', $offLargeOrder);
        $stmt->bindValue('state', $state);
        $stmt->bindValue('customerId', $customerId);
        $stmt->execute();

        if (!$inTransaction) {
            $this->db->commit();
        }
    }

*/





}

