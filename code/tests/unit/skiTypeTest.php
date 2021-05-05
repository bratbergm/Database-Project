<?php
require_once 'RESTConstants.php';
require_once 'controller/APIController.php';

class skiTypeTest extends \Codeception\Test\Unit {
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
     * Tests if possible to retrieve list of ski types
     */
    public function testGetCollection() {
        $controller = new PublicEndpoint();

        $token = RESTConstants::TOKEN_PUBLIC;
        $uri = ['skitypes'];
        $requestMethod = RESTConstants::METHOD_GET;
        $queries = array();
        $payload = array();

        $res = $controller->handleRequest($token, $uri, $requestMethod, $queries, $payload);
        $this->tester->assertCount(5, $res);
    }

    /**
     * Tests if possible to retrieve a given skiType
     */
    public function testGetResource() {
        $controller = new PublicEndpoint();

        $res = $controller->handleRequest(RESTConstants::TOKEN_PUBLIC, ['skitypes', 'Endurance'], 'GET', [], []);
        self::assertNotEmpty($res);
        if (isset($res['model'])) {
            self::assertEquals('Endurance', $res['model']);
        }
    }







}



