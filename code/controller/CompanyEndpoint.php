<?php
require_once 'db/skisModel.php';

/**
 * CompanyEndpoint class. The controller for the Company Endpoint
 */
class CompanyEndpoint {

    /**
     * Function for dispatching to the different types of employees based on token
     * @param string $token from the user
     * @param array $uri
     * @param string $requestMethod
     * @param array $queries
     * @param array $payload
     * @see handleStoreKeeperRequest
     * @see handleCustomerRepRequest
     */
    public function handleRequest (string $token, array $uri, string $requestMethod, array $queries, array $payload): array {
        switch ($token) {
            case RESTConstants::TOKEN_STOREKEEPER:
                return $this->handleStoreKeeperRequest($uri, $requestMethod, $queries, $payload);
                break;
            case RESTConstants::TOKEN_CUSTOMERREP:
                return $this->handleCustomerRepRequest($uri, $requestMethod, $queries, $payload);
                break;
        }
      
    }

    /**
     * Function for dispatching a Store keeper's requests based on the $uri. Only Skis is implemented now.
     * @param array $uri The URI from the user
     * @param string $requestMethod 
     * @param array $queries 
     * @param array $payload Data from user that wil be inserted into database
     * @see storeKeeperEndpoint
     */
    public function handleStoreKeeperRequest (array $uri, string $requestMethod, array $queries, array $payload): array {
        $endpointUri = $uri[0];
        switch ($endpointUri) {
            case RESTConstants::ENDPOINT_SKIS:
                return $this->storeKeeperEndpoint($uri, $requestMethod, $queries, $payload);
                break;

        }
    }
        

    /**
     * Controller for the Store keeper endpoint.
     * @param array $uri The URI from the user
     * @param string $requestMethod 
     * @param array $queries 
     * @param array $payload Data from user that wil be inserted into database
     * @see SkiModel::getRecord 
     */
    public function storeKeeperEndpoint (array $uri, string $requestMethod, array $queries, array $payload): array {   
        switch ($requestMethod) {
            case RESTConstants::METHOD_GET:
                if (count($uri) == 3 && $uri[1] == 'date') {
                    // Skis with a filter (production date)
                    $record = new SkiModel();
                    return $record->getRecord($uri[2]); 
                } //Else: Error handling: Not allowed
            case RESTConstants::METHOD_POST:
                // Create new record (not implemented)
        }
    return array();
    }

    /**
     * Function for dispatching a Customer Rep's requests based on the $uri. Only Orders is implemented now.
     * @param array $uri The URI from the user
     * @param string $requestMethod 
     * @param array $queries 
     * @param array $payload Data from user that wil be inserted into database
     */
    public function handleCustomerRepRequest (array $uri, string $requestMethod, array $queries, array $payload): array {
        $endpointUri = $uri[0];
        switch ($endpointUri) {
            case RESTConstants::ENDPOINT_ORDERS:
                return $this->customerRepEndpoint($uri, $requestMethod, $queries, $payload);
                break;
        }
    
    return array();
    }


    /**
     * Controller for the Customer Rep endpoint.
     * @param array $uri The URI from the user
     * @param string $requestMethod 
     * @param array $queries 
     * @param array $payload Data from user that wil be inserted into database
     * @see OrderModel::getOrders Retreives basic info on all orders
     * @see OrderModel::getOrderWithItems Returns an order based on order number with all information on items in the order
     * @see OrderModel::getOrdersState Returns orders based on state with all information on items in the order
     * @see OrderModel::updateOrderState Updates an orders state
     */
    public function customerRepEndpoint (array $uri, string $requestMethod, array $queries, array $payload) {
        switch ($requestMethod) {
            case RESTConstants::METHOD_GET:
                if (count($uri) == 1) {
                // Basic info on all orders
                    $order = new OrderModel();
                    return $order->getOrders();
                // Retreive an order based on order number  
                } elseif (count($uri) == 2 && ctype_digit($uri[1])) {
                    $order = new OrderModel();
                    return $order->getOrderWithItems(intval($uri[1]));
                // Retreive orders based on state
                } elseif (count($uri) == 2 && ctype_alpha($uri[1])) {
                    $order = new OrderModel();
                    return $order->getOrdersState($uri[1]);
                }
                break;
            case RESTConstants::METHOD_PUT:
                // Cange an orders state 
                $order = new OrderModel();
                return $order->UpdateOrderState(intval($uri[1]), $uri[2]);
        }
    }



}



/**
 * Storekeeper:
 *    Create records newly produced skis
 * 
 * Customer rep:
 *    Retrieve orders with status filter set to new
 *    Change the order state from new to open for an unassigned order
 */




