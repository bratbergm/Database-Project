<?php
require_once 'RESTConstants.php';
require_once 'db/OrdersModel.php';
require_once 'db/SkisModel.php';
require_once 'db/SkiTypesModel.php';

class APIController {


    public function isValidEndpoint(array $uri): bool {
        if ($uri[0] == RESTConstants::ENDPOINT_ORDERS) {
            if (count($uri) == 1) {
                // A request for the collection of orders
                return true;
            } elseif (count($uri) == 2) {
                // The "orders number" must be a digit 
                //return ctype_digit($uri[1]);
                return true;
            } elseif (count($uri) == 3) {
                // state must be new, open or available
                return true;
            }
        } elseif ($uri[0] == RESTConstants::ENDPOINT_SKIS) {
            if (count($uri) == 1) {
                // A request for the collection of skis
                return true;
            } elseif (count($uri) == 2) {
                // A request for a defined ski 
                return true;
            } elseif (count($uri) == 3) {
                // A request for skis with some filter
                return true;
            }
        } elseif ($uri[0] == RESTConstants::ENDPOINT_SKITYPES) {

            return true;
        }
        return false;
    }

    public function isValidMethod(array $uri, string $requestMethod): bool {
        switch ($uri[0]) {
            case RESTConstants::ENDPOINT_ORDERS:
                // GET requests for orders may be for all orders (/orders) or a specific order (/orders/{number})
                return $requestMethod == RESTConstants::METHOD_GET || $requestMethod == RESTConstants::METHOD_PUT || $requestMethod == RESTConstants::METHOD_POST;
                break;
            case RESTConstants::ENDPOINT_SKIS:
                return $requestMethod == RESTConstants::METHOD_GET;
                break;
            case RESTConstants::ENDPOINT_SKITYPES:
                return $requestMethod == RESTConstants::METHOD_GET;
                break;
        }
        return false;
    }

    public function isValidPayload(array $uri, string $requestMethod, array $payload): bool {
        if ($requestMethod == RESTConstants::METHOD_GET)  {
            return true;
        } elseif ($requestMethod == RESTConstants::METHOD_PUT) {
            if (count($uri) == 3) {             // new, open, available
                return true;
            }
        } elseif ($requestMethod == RESTConstants::METHOD_POST) {
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
            case RESTConstants::ENDPOINT_SKIS:
                return $this->handleSkiRequest($uri, $requestMethod, $queries, $payload);
                break;
            case RESTConstants::ENDPOINT_SKITYPES:
                return $this->handleSkiTypeRequest($uri, $requestMethod, $queries, $payload);
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
            // Update order state
        } elseif ($requestMethod == RESTConstants::METHOD_PUT) {
            $order = new OrderModel();
            return $order->UpdateOrderState(intval($uri[1]), $uri[2]);
        } elseif ($requestMethod == RESTConstants::METHOD_POST) {
            $order = new OrderModel();
            return $order->createResource($payload);   // Working on this
        }
    }


    protected function handleSkiRequest(array $uri, string $requestMethod, array $queries, array $payload): array {
        if (count($uri) == 1) {
            $ski = new SkiModel();
            return $ski->getCollection();
        } elseif (count($uri) == 2 && ctype_digit($uri[1])) {
            // Ski pnr
            $ski = new SkiModel();
            return $ski->getRecource($uri[1]); 
        } elseif (count($uri) == 3 ) {  //&& ctype_alpha($uri[1])
            // Skis with a filter (prod. date)
            $ski = new SkiModel();
            return $ski->getRecord($uri[2]); 
        }
    }

    protected function handleSkiTypeRequest(array $uri, string $requestMethod, array $queries, array $payload): array {
        if (count($uri) == 1) {
            // All skitypes
            $skiType = new SkiTypeModel();
            return $skiType->getCollection();
        } elseif (count($uri) == 2) {
            // Ski types with model filter
            $skiType = new SkiTypeModel();
            return $skiType->getResource($uri[1]);
        }
    }   
}