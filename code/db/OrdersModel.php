<?php


/**
 * Class for orders. Generates JSON documents from the dbproject database 
 * 
 */

class OrderModel {

    protected $db;

    public function __construct() {
        $this->db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8',
            DB_USER, DB_PWD,
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }


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



// Orders
    public function getOrdersWithItems(): array {
        $res = array();

    $query = "SELECT number AS orderNumber, totalPrice, state FROM `order`";

        $stmt = $this->db->query($query);

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
    public function getItemsForOrder($orderNumber) {
        $res = array();

        $query = "SELECT itemNr, ski_pnr, order_number
        FROM orderitem
        WHERE order_number = :order_number";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':order_number', $orderNumber);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pos = count($res);
            $res[] = $row;

            $res[$pos]['ski_pnr'] = $this->getSkisForItems($row['ski_pnr']);
        }

        return $res;
    }


// Skis
    public function getSkisForItems($itemNr) {
        $res = array();

        $query = "SELECT pnr, type, model, typeOfSkiing, temperature, size, weightClass, gripSystem, descripton, msrp, productionDate 
        FROM ski
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


    public function createOrdersItemsDoc(): string {
        return json_encode($this->getOrdersWithItems());
    }



}

