<?php
require_once 'db/SkiTypesModel.php';

/**
 * PublicEndpoint class. This is the public endpoint coontroller.
 */
class PublicEndpoint {

    /**
     * Function for dispatching a Public users requests based on the $uri.
     * @param $token Only used in Company endpoint
     * @param array $uri The URI from the user
     * @param string $requestMethod 
     * @param array $queries 
     * @param array $payload Data from user that wil be inserted into database
     * @see handleSkiTypeRequest
     */
    public function handleRequest(string $token, array $uri, string $requestMethod, array $queries, array $payload): array {
        $endpointUri = $uri[0];
        switch ($endpointUri) {
            case RESTConstants::ENDPOINT_SKITYPES:
                return $this->handleSkiTypeRequest($uri, $requestMethod, $queries, $payload);
                break;
        }
        return array();
    }

    /**
     * Function for handling Ski Type requests
     * @param array $uri The uri from the user
     * @param string $requestMethod 
     * @param array $queries 
     * @param array $payload Data from user that wil be inserted into database
     * @see SkiTypeModel::getCollection Retreives all skitypes
     * @see SkiTypeModel::getResource Retreives list of ski types based on model
     */
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