<?php
require_once 'db/skisModel.php';

/**
 * CompanyEndpoint class. The controller for the Company Endpoint
 */
class CompanyEndpoint {

    /**
     * Function for dispatching based on type of employee
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


    public function handleStoreKeeperRequest (array $uri, string $requestMethod, array $queries, array $payload): array {
        $endpointUri = $uri[0];
        switch ($endpointUri) {
            case RESTConstants::ENDPOINT_SKIS:
                return $this->storeKeeperEndpoint($uri, $requestMethod, $queries, $payload);
                break;

        }
    }
        

        
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


    public function handleCustomerRepRequest (array $uri, string $requestMethod, array $queries, array $payload): array {
        $endpointUri = $uri[0];
        switch ($endpointUri) {
            case RESTConstants::ENDPOINT_ORDERS:
                return $this->customerRepEndpoint($uri, $requestMethod, $queries, $payload);
                break;
        }
    
    return array();
    }


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




