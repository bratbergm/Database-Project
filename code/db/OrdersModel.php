<?php
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
 * Returns basic information on all orders.
 * Might remove this function
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
        $stmt = $this->db->prepare("SELECT number AS orderNumber, totalPrice, state FROM `order` WHERE state = :state");
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
        //    $res[$pos]['ski_pnr'] = $row['ski_pnr'];

            $res[$pos]['ski_pnr'] = $this->getSkisForItems($row['ski_pnr']);
        }

        return $res;
    }


// Skis
    public function getSkisForItems(int $itemNr) {
        $res = array();

        $query = "SELECT pnr, ski.type, ski.model, ski.temperature, ski.size, ski.weightClass, ski.gripSystem, ski.productionDate, skitype.type, skitype.typeOfSkiing, skitype.descripton, skitype.historical, skitype.msrp
        FROM ski
        INNER JOIN skitype ON skitype.type = ski.type
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




/*
    public function createOrdersItemsDoc($number): string {
        return json_encode($this->getOrderWithItems());
    }
*/





}

