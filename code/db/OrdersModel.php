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
 * @return array Returns an array of associative arrays with the requested data.
 *               If the data is not found, it returns an empty array.
 */
    public function getOrders(): array {
        $res = array();

        $query = "SELECT number, totalPrice, offLargeOrder, state, customerId FROM `order`";

        $stmt = $this->db->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pos = count($res);
            $res[] = array();

            $res[$pos]['number'] = $row['number'];
            $res[$pos]['totalPrice'] = $row['totalPrice'];
            $res[$pos]['offLargeOrder'] = $row['offLargeOrder'];
            $res[$pos]['state'] = $row['state'];
            $res[$pos]['customerId'] = $row['customerId'];
        }
        return $res;
    }

    public function createOrdersDoc(): string {
        return json_encode($this->getOrders());
    }


/**
 * Returns orders based on state.
 * With all information on items in the order.
 * @param string $state The state that is requested
 * @see getItemsForOrder Retreives the items for each order
 * @return array Returns an array of associative arrays with the requested data.
 *               If the data is not found, it returns an empty array.
 */
    public function getOrdersState(string $state) {
        $res = array();
        $stmt = $this->db->prepare("SELECT number AS orderNumber, totalPrice, offLargeOrder, state, customerId 
        FROM `order` 
        WHERE state = :state");
        
        $stmt->bindValue('state', $state);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pos = count($res);
            $res[] = array();

            $res[$pos]['orderNumber'] = $row['orderNumber'];
            $res[$pos]['totalPrice'] = $row['totalPrice'];
            $res[$pos]['offLargeOrder'] = $row['offLargeOrder'];
            $res[$pos]['state'] = $row['state'];
            $res[$pos]['customerId'] = $row['customerId'];

            $res[$pos]['Items'] = $this->getItemsForOrder($row['orderNumber']);
        }
        return $res;
    }

/**
 * Returns an order based on order number
 * With all information on items in the order.
 * @param int $number The requested order number
 * @see getItemsForOrder Retreives the items for each order
 * @return array Returns an array of associative arrays with the requested data.
 *               If the data is not found, it returns an empty array.
 */
public function getOrderWithItems(int $number): array {
    $res = array();

    $stmt = $this->db->prepare("SELECT number AS orderNumber, totalPrice, offLargeOrder, state, customerId 
    FROM `order` 
    WHERE number = :number");
    $stmt->bindValue(':number', $number);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $pos = count($res);
        $res[] = array();

        $res[$pos]['orderNumber'] = $row['orderNumber'];
        $res[$pos]['totalPrice'] = $row['totalPrice'];
        $res[$pos]['offLargeOrder'] = $row['offLargeOrder'];
        $res[$pos]['state'] = $row['state'];
        $res[$pos]['customerId'] = $row['customerId'];

        $res[$pos]['Items'] = $this->getItemsForOrder($row['orderNumber']);
    }
    return $res;
}


    /**
     * Returns the items in the orders retreived in getOrdersState and getOrderWithItems
     * @param int $orderNumber The ordernumber in which to retrieve items for
     * @see getSkisForItems
     * @return array Returns an array of associative arrays with the requested data.
     *               If the data is not found, it returns an empty array.
     */
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
            $res[] = array();
    
            $res[$pos]['order_number'] = $row['order_number'];
            $res[$pos]['ski_pnr'] = $row['ski_pnr'];

            $res[$pos]['ski_pnr'] = $this->getSkisForItems($row['ski_pnr']);
        }
        return $res;
    }


    /**
     * Returns the skis with all info 
     * @param int $intemNr The ski.productionNumber for the order
     * @return array Returns an array of associative arrays with the requested data.
     *               If the data is not found, it returns an empty array.
     */
    public function getSkisForItems(int $itemNr) {
        $res = array();

        $query = "SELECT pnr, ski.size, ski.weightClass, ski.productionDate, ski.ski_type_id, skiType.id, skiType.type, skiType.model, skiType.temperature, skiType.gripSystem, skiType.typeOfSkiing, skiType.descripton, skiType.historical, skiType.msrp
        FROM ski
        INNER JOIN skitype ON skitype.id = ski.ski_type_id
        WHERE pnr = :pnr";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':pnr', $itemNr);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $res[] = $row;
        }
        // Skitypes and skis BRUK skisModel->getRecource ?



/*
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pos = count($res);
            $res[] = array();
    
            $res[$pos]['ski.pnr'] = $row['ski.pnr'];
            $res[$pos]['ski.size'] = $row['ski.size'];
            $res[$pos]['ski.weightClass'] = $row['ski.weightClass'];
            $res[$pos]['ski.productionDate'] = $row['ski.productionDate'];
            $res[$pos]['ski.ski_type_id'] = $row['ski.ski_type_id'];
            $res[$pos]['skiType.id'] = $row['skiType.id'];
            $res[$pos]['skiType.type'] = $row['skiType.type'];
            $res[$pos]['skiType.model'] = $row['skiType.model'];
            $res[$pos]['skiType.temperature'] = $row['skiType.temperature'];
            $res[$pos]['skiType.gripSystem'] = $row['skiType.gripSystem'];
            $res[$pos]['skiType.typeOfSkiing'] = $row['skiType.typeOfSkiing'];
            $res[$pos]['skiType.descripton'] = $row['skiType.descripton'];
            $res[$pos]['skiType.historical'] = $row['skiType.historical'];
            $res[$pos]['skiType.msrp'] = $row['skiType.msrp'];

        }
  */      
        return $res;
    }


    /**
     * Changing the state of an order from new to open after reviewing it
     * Updates state to value in uri[2], for the order with order number value in uri[1]
     * TO DO:
     *  - Check if input from user is new, open or skis avalable 
     * @param int $number The order number that is being updated
     * @param string $state The state the order is being updated to
     * @param bool $inTransaction
     * 
     */
    public function updateOrderState(int $number, string $state, bool $inTransaction = false) {

        if (!$inTransaction) {
            $this->db->beginTransaction();
        }

        $stmt = $this->db->prepare("SELECT number AS orderNumber, state
        FROM `order`  WHERE number = :number");
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

        $stmt = $this->db->prepare("SELECT number AS orderNumber, state
        FROM `order`  WHERE number = :number");
        $stmt->bindValue(':number', $number);
        $stmt->execute();
    }




    /**
     * Add a new order
     * @param array $resource The order data from user to be inserted into the database
     * @param bool $inTransaction
     */
    public function createResource(array $resource, bool $inTransaction = false) {
            if (!$inTransaction) {
                $this->db->beginTransaction();
            }
    
            $res = array();
    
            $query = 'INSERT INTO `order`
            (totalPrice, offLargeOrder, state, customerId)
            VALUES (:totalPrice, :offLargeOrder, :state, :customerId)';
    
            $stmt = $this->db->prepare($query);
    
            $stmt->bindValue(':totalPrice', $resource['totalPrice']); // Må regnes ut et sted. Flytt msrp til ski?
            $stmt->bindValue(':offLargeOrder', $resource['offLargeOrder']);
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
            return $res;
    
    }


    /**
     * Deletes an order
     * @param int $number The order number that is to be deleted
     */
    public function deleteResource(int $number) {
        $stmt = $this->db->prepare("DELETE FROM `order` WHERE number = :number");
        $stmt->bindValue(':number', $number);
        $stmt->execute();
    }





}

