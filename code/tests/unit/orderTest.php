<?php
require_once 'RESTConstants.php';
require_once 'controller/APIController.php';

class orderTest extends \Codeception\Test\Unit {
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
     * Tests if GET order number 1 is a valid endpoint. it is.
     */
    public function testIsValidEndpoint() {
        $controller = new APIController();
        self::assertEquals(true, $controller->isValidEndpoint(['orders', '1'], 'GET', []));
    }

    /**
     * Tests if GET order number 999 is a valid endpoint. It's not.
     */
    public function testIsNotValidEndpoint() {
        $controller = new APIController();
        self::assertEquals(true, $controller->isValidEndpoint(['orders', '999'], 'GET', []));
    }

    /**
     * Tests if order number 1 exists
     */
    public function testExistingOrderResource() {
        $controller = new APIController();
        $res = $controller->handleRequest(['orders', '1'], 'GET', [], []);
        self::assertNotEmpty($res);
    }

    /**
     * Tests if order number 999 does not exist (it does not)
     */
    public function testNonExistingOrderResource() {
        $controller = new APIController();
        $res = $controller->handleRequest(['orders', '999'], 'GET', [], []);
        self::assertEmpty($res);
    }

    /**
     * Tests how many orders have state 'new'. 2 does.     
     */
    public function testOrderStateNew() {
        $controller = new APIController();
        $res = $controller->handleRequest(['orders', 'new'], 'GET', [], []);
        self::assertNotEmpty($res);
        self::assertCount(2, $res);
    }

    /**
     * Tests if possible to create new order
     */
    public function testPutOrder() {
        $uri = ['/orders/123'];
        $requestMethod = RESTConstants::METHOD_POST;
        $queries = array();
        $payload = array();

        $controller = new APIController();

        $controller->handleRequest($uri, $requestMethod, $queries, $payload);

        $res = $controller->handleRequest(['orders', '123'], 'GET', [], []);
        self::assertNotEmpty($res);
    }

   /**
    * Tests if possible to update state of an order. Currently working on this.
    * TO DO: add token check
    */
    public function testPutOrderState() {
    

    }








}