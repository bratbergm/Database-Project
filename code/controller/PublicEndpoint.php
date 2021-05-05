<?php
require_once 'db/SkiTypesModel.php';

/**
 * PublicEndpoint class. This is the public endpoint coontroller.
 */
class PublicEndpoint {

    public function handleRequest(string $token, array $uri, string $requestMethod, array $queries, array $payload): array {
        $endpointUri = $uri[0];
        switch ($endpointUri) {
            case RESTConstants::ENDPOINT_SKITYPES:
                return $this->handleSkiTypeRequest($uri, $requestMethod, $queries, $payload);
                break;
        }
        return array();
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