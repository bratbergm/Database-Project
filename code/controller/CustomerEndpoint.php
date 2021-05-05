<?php
require_once 'db/OrdersModel.php';
require_once 'db/productionPlanModel.php';

/**
 * CustomerEndpoint class. The controller for the Customer Endpoint
 */
class CustomerEndpoint {

    /**
     * Function for dispatching requests based on the $uri
     * @param array $uri The uri from the user
     * @param string $requestMethod 
     * @param array $queries 
     * @param array $payload Data from user that wil be inserted into database
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
        }
    }

    public function handlePlanRequest(array $uri, string $requestMethod, array $queries, array $payload): array {
        // legg til switch på req method, for fremtidig utvikling
        $plan = new ProductionPlanModel();
        return $plan->getRecource($uri[1]);

       
    }


    public function handleSkiRequest (array $uri, string $requestMethod, array $queries, array $payload): array {

    }


    public function handleSkiTypeRequest (array $uri, string $requestMethod, array $queries, array $payload): array {

    }

/*
Customer:

Retrieve a four week production plan summary
Delete a given order
*/




}