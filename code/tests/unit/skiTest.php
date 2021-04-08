<?php
require_once 'RESTConstants.php';
require_once 'controller/APIController.php';

class skiTest extends \Codeception\Test\Unit {
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
     * Tests if possible to retrieve list of skis   
    */
    public function testGetCollection() {
        $controller = new APIController();

        $uri = ['skis'];
        $requestMethod = RESTConstants::METHOD_GET;
        $queries = array();
        $payload = array();

        $res = $controller->handleRequest($uri, $requestMethod, $queries, $payload);
        $this->tester->assertCount(20, $res);
    }


    /**
     * Tests if possible to retrieve a given ski
     */
    public function testGetResource() {
        $controller = new APIController();

        $res = $controller->handleRequest(['skis', '1'], 'GET', [], []);
        self::assertNotEmpty($res);
        if (isset($res['pnr'])) {
            self::assertEquals(1, $res['pnr']);
        }
        
    }

    /**
     * Tests retrieve record of produced skis since a date
     */
    public function testGetFilterResource() {

    }


}

