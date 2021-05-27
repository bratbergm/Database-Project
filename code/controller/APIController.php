<?php
require_once 'RESTConstants.php';
require_once 'db/OrdersModel.php';
require_once 'db/AuthorisationModel.php';
require_once 'PublicEndpoint.php';
require_once 'CustomerEndpoint.php';
require_once 'CompanyEndpoint.php';



class APIController {

    /**
     * Checks if the endpoint in the uri is valid and that the user (TOKEN) is allowed to access the requested data
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



    /** TO DO: Error handling; user not authenticated (No token match)
     * Function for handling client requests to the API. Checks the token and redirects
     * the request to the respective endpoint.
     * @see PublicEndpoint controller for the public endpoint
     * @see CustomerEndpoint controller for the customer endpoint
     * @see CompanyEndpoint controller for the company endpoint. For Storekeeper, CustomerRep and productionPlanner 
     */
    public function handleRequest(string $token, array $uri, string $requestMethod, array $queries, array $payload): array {
       // Validate that the token is one of the stored tokens in the database
        if(!(new AuthorisationModel())->validateToken($token)) {
            throw new Exception(RESTConstants::HTTP_FORBIDDEN);           
        }

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

  
}