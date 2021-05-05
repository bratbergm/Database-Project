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
        self::assertEquals(false, $controller->isValidEndpoint(['ordersFail', '999'], 'GET', []));
    }

    /**
     * Tests if order number 1 exists
     */
    public function testExistingOrderResource() {
        $controller = new APIController();
        $res = $controller->handleRequest(RESTConstants::TOKEN_CUSTOMER, ['orders', '1'], 'GET', [], []);
        self::assertNotEmpty($res);
    }

    /**
     * Tests if order number 999 does not exist (it does not)
     */
    public function testNonExistingOrderResource() {
        $controller = new APIController();
        $res = $controller->handleRequest(RESTConstants::TOKEN_CUSTOMER, ['orders', '999'], 'GET', [], []);
        self::assertEmpty($res);
    }

    /**
     * Tests how many orders have state 'new'. 2 does.     
     */
    public function testOrderStateNew() {
        $controller = new APIController();
        $res = $controller->handleRequest(RESTConstants::TOKEN_CUSTOMERREP, ['orders', 'new'], 'GET', [], []);
        self::assertNotEmpty($res);
        self::assertCount(2, $res);
    }


   
    /**
     * Tests if possible to delete an order
     */
    public function testOrderDelete() {
        $controller = new APIController();
        $controller->handleRequest(RESTConstants::TOKEN_CUSTOMER, ['orders', '1'], 'DELETE', [], []);
        //Check if deleted
        $res = $controller->handleRequest(RESTConstants::TOKEN_CUSTOMER, ['orders', '1'], 'GET', [], []);
        self::assertEmpty($res);
    }







}