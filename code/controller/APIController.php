<?php
require_once 'RESTConstants.php';
require_once 'db/OrdersModel.php';

class APIController {


    public function isValidEndpoint(array $uri): bool
    {
        if ($uri[0] == RESTConstants::ENDPOINT_ORDERS) {
            if (count($uri) == 1) {
                // A request for the collection of orders
                return true;
            } elseif (count($uri) == 2) {
                // The "orders number" must be a digit
                //return ctype_digit($uri[1]);
                return true;
            }
        }
        return false;
    }

    public function isValidMethod(array $uri, string $requestMethod): bool {
        switch ($uri[0]) {
            case RESTConstants::ENDPOINT_ORDERS:
                // GET requests for orders may be for all orders (/orders) or a specific order (/orders/{number})
                return count($uri) == 2 || count($uri) == 1 && $requestMethod == RESTConstants::METHOD_GET;
        }
        return false;
    }

    public function isValidPayload(array $uri, string $requestMethod, array $payload): bool
    {
        // No payloads to test for GET methods
        if ($requestMethod == RESTConstants::METHOD_GET)  {
            return true;
        }
        return false;
    }



    public function handleRequest(array $uri, string $requestMethod, array $queries, array $payload): array {
        $endpointUri = $uri[0];
        switch ($endpointUri) {
            case RESTConstants::ENDPOINT_ORDERS:
                return $this->handleOrderRequest($uri, $requestMethod, $queries, $payload);
                break;
        }
    return array();
    }

    protected function handleOrderRequest(array $uri, string $requestMethod, array $queries, array $payload): array {
        if (count($uri) == 1) {
            // Only /orders
            $order = new OrderModel();
            return $order->getOrders();
            // /orders/orderNumber
        } elseif (count($uri) == 2 && ctype_digit($uri[1])) {
            $order = new OrderModel();
            return $order->getOrderWithItems(intval($uri[1]));
            // /orders/state
        } elseif (count($uri) == 2 && ctype_alpha($uri[1])) {
            $order = new OrderModel();
            return $order->getOrdersState($uri[1]);
        }
    }



}