<?php
require_once 'db/OrdersModel.php';
require_once 'db/productionPlanModel.php';

/**
 * CustomerEndpoint class. The controller for the Customer Endpoint
 */
class CustomerEndpoint {

    /**
     * Function for dispatching requests based on the $uri
     * @param string $token only used in company endpoint 
     * @param array $uri The uri from the user
     * @param string $requestMethod 
     * @param array $queries 
     * @param array $payload Data from user that wil be inserted into database
     * @see handleOrderRequest
     * @see handlePlanRequest
     * @see handleSkiRequest
     * @see handleSkiTypeRequest
     * 
     */
    public function handleRequest(string $token, array $uri, string $requestMethod, array $queries, array $payload): array {
        $endpointUri = $uri[0];
        switch ($endpointUri) {
            case RESTConstants::ENDPOINT_ORDERS:
                return $this->handleOrderRequest($uri, $requestMethod, $queries, $payload);
                break;
            case RESTConstants::ENDPOINT_PLAN:
                return $this->handlePlanRequest($uri, $requestMethod, $queries, $payload);
                break;
            case RESTConstants::ENDPOINT_SKIS:
                return $this->handleSkiRequest($uri, $requestMethod, $queries, $payload);
                break;
            case RESTConstants::ENDPOINT_SKITYPES:
                return $this->handleSkiTypeRequest($uri, $requestMethod, $queries, $payload);
                break;
        }
        return array();
    }

    
    /**
     * Function for handling order requests
     * @param array $uri The uri from the user
     * @param string $requestMethod 
     * @param array $queries 
     * @param array $payload Data from user that wil be inserted into database
     * @see OrderModel::getOrders Returns basic information on all orders
     * @see OrderModel::getOrderWithItems Returns an order based on order number with all information on items in the order
     * @see OrderModel::createResource Adding a new order
     * @see OrderModel::deleteResource Deletes an order
     */
    public function handleOrderRequest(array $uri, string $requestMethod, array $queries, array $payload): array {
        switch ($requestMethod) {
            case RESTConstants::METHOD_GET:
                // Only /orders
                if (count($uri) == 1) {
                    $order = new OrderModel();
                    return $order->getOrders();
                // /orders/orderNumber    
                } elseif (count($uri) == 2) {
                    $order = new OrderModel();
                    return $order->getOrderWithItems(intval($uri[1]));
                }
                break;
            case RESTConstants::METHOD_POST:
                $order = new OrderModel();
                return $order->createResource($payload);
                break;
            case RESTConstants::METHOD_DELETE:
                $order = new OrderModel();
                return $order->deleteResource($uri[1]);
                break;
        }
    }

    /**
     * Function for handling plan requests. 
     * TO DO: add switch on request method for future development.
     * @param array $uri The uri from the user
     * @see ProductionPlanModel::getRecource Retreives a four week productionplan summary from a given period
     * 
     */
    public function handlePlanRequest(array $uri, string $requestMethod, array $queries, array $payload): array {
 
        $plan = new ProductionPlanModel();
        return $plan->getRecource($uri[1]);
    }


    public function handleSkiRequest (array $uri, string $requestMethod, array $queries, array $payload): array {

    }


    public function handleSkiTypeRequest (array $uri, string $requestMethod, array $queries, array $payload): array {

    }


}