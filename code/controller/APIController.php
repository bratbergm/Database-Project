<?php
require_once 'RESTConstants.php';
require_once 'db/OrdersModel.php';
//require_once 'db/SkisModel.php';
require_once 'db/AuthorisationModel.php';
require_once 'PublicEndpoint.php';
require_once 'CustomerEndpoint.php';
require_once 'CompanyEndpoint.php';
//require_once 'db/SkiTypesModel.php';


class APIController {



    /**
     * Checks if the endpoint in the uri is valid
     * @param array $uri The requested uri
     */
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
        } elseif ($uri[0] == RESTConstants::ENDPOINT_PLAN) {

            return true;
        }
        return false;
    }

    /**
     * Checks is the requested method is allowed for the requested endpoint
     * @param array $uri The requested URI
     * @param string $requestMethod The requested method
     */
    public function isValidMethod(array $uri, string $requestMethod): bool {
        switch ($uri[0]) {
            case RESTConstants::ENDPOINT_ORDERS:
                // GET requests for orders may be for all orders (/orders) or a specific order (/orders/{number})
                return $requestMethod == RESTConstants::METHOD_GET || $requestMethod == RESTConstants::METHOD_PUT || $requestMethod == RESTConstants::METHOD_POST || $requestMethod == RESTConstants::METHOD_DELETE;
                break;
            case RESTConstants::ENDPOINT_SKIS:
                return $requestMethod == RESTConstants::METHOD_GET;
                break;
            case RESTConstants::ENDPOINT_SKITYPES:
                return $requestMethod == RESTConstants::METHOD_GET;
                break;
            case RESTConstants::ENDPOINT_PLAN:
                // Now, only custumer can only GET production plans
                return $requestMethod == RESTConstants::METHOD_GET;
                break;
        }
        return false;
    }

    /**
     * TO DO
     *      Checks if the payload is correctly formatted
     *      @param array $uri The requested URI
     *      @param string $requestMethod The requested method
     *      @param array $payload The Payload from the user
     */
    public function isValidPayload(array $uri, string $requestMethod, array $payload): bool {
        if ($requestMethod == RESTConstants::METHOD_GET)  {
            return true;
        } elseif ($requestMethod == RESTConstants::METHOD_PUT) {
            if (count($uri) == 3) {             // new, open, available
                return true;
            }
        } elseif ($requestMethod == RESTConstants::METHOD_POST) {
            return true;
        } elseif ($requestMethod == RESTConstants::METHOD_DELETE) {
            return true;
        }
        return false;
    }


 /*
    // Validate that the token is one of the stored tokens in the database
    public function authorise(string $token) {
        if((new AuthorisationModel())->validateToken($token)) {
            return false;
        }
    }
*/

    /**
     * Function for handling client requests to the API. Checks the token and redirects
     * the request to the respective endpoint.
     * @see PublicEndpoint controller for the public endpoint
     * @see CustomerEndpoint controller for the customer endpoint
     * @see CompanyEndpoint controller for the company endpoint. For Storekeeper, CustomerRep and productionPlanner 
     */
    public function handleRequest(string $token, array $uri, string $requestMethod, array $queries, array $payload): array {
       // Validate that the token is one of the stored tokens in the database
        if(!(new AuthorisationModel())->validateToken($token)) {
            return false;
        } //Else: Error handling: Not allowed (try, catch)

        switch ($token) {
            case RESTConstants::TOKEN_PUBLIC:
                $endpoint = new PublicEndpoint();
                break;
            case RESTConstants::TOKEN_CUSTOMER:
                $endpoint = new CustomerEndpoint();
                break;
            case RESTConstants::TOKEN_CUSTOMERREP:
                $endpoint = new CompanyEndpoint();
                break;
            case RESTConstants::TOKEN_STOREKEEPER:
                $endpoint = new CompanyEndpoint();
                break;
        }   // token is used further in the CompanyEndpoint
        return $endpoint->handleRequest($token, $uri, $requestMethod, $queries, $payload);
    }


/*
public function handleRequest(string $token, array $uri, string $requestMethod, array $queries, array $payload): array {
    if ($token == 'efa1f375d76194fa51a3556a97e641e61685f914d446979da50a551a4333ffd7') {
        $endpoint = new PublicEndpoint();
        return $endpoint->handleRequest($uri, $requestMethod, $queries, $payload);
    }
}
*/

//  Denne blir å finnes i hvert endpoint
/*
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
*/

    


    /**
     * To do:
     * Flytt til egen order controller, bruk switch på methode? istede
     */
    protected function handleOrderRequest(array $uri, string $requestMethod, array $queries, array $payload): array {
        if (count($uri) == 1 && $requestMethod == RESTConstants::METHOD_GET) {
            // Only /orders
            $order = new OrderModel();
            return $order->getOrders();
            // /orders/orderNumber
        } elseif (count($uri) == 2 && ctype_digit($uri[1]) && $requestMethod == RESTConstants::METHOD_GET) {
            $order = new OrderModel();
            return $order->getOrderWithItems(intval($uri[1]));
            // /orders/state
        } elseif (count($uri) == 2 && ctype_alpha($uri[1]) && $requestMethod == RESTConstants::METHOD_GET) {
            $order = new OrderModel();
            return $order->getOrdersState($uri[1]);
            // Update order state
        } elseif ($requestMethod == RESTConstants::METHOD_PUT) {
            $order = new OrderModel();
            return $order->UpdateOrderState(intval($uri[1]), $uri[2]);
        } elseif ($requestMethod == RESTConstants::METHOD_POST) {
            $order = new OrderModel();
            return $order->createResource($payload);   
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