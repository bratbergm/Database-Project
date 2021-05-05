<?php
require_once 'RESTConstants.php';
require_once 'controller/APIController.php';

class productionPlanTest extends \Codeception\Test\Unit {
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests

    /**
     * Tests if possible to retreive an productionplan base on period input

     */
    public function testGetResource() {
        $token = RESTConstants::TOKEN_CUSTOMER;
        $uri = ['plans', '2021-02'];
        $requestMethod = RESTConstants::METHOD_GET;
        $queries = array();
        $payload = array();

        $endpoint = new CustomerEndpoint();

        $res = $endpoint->handleRequest($token, $uri, $requestMethod, $queries, $payload);
        self::assertNotEmpty($res);
        
    }





}