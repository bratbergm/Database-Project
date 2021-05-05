<?php
require_once 'Authorisation.php';

class dbprojectCest {
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
    }

     /**
     * Tests if possible to retreive orders based on state
     */
    public function testFilteredGetCollection(ApiTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');
        Authorisation::setAuthorisationToken($I);
        $I->sendGet('/orders');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();

//      $I->assertEquals(2, count(json_decode($I->grabResponse())));
        $I->seeResponseContainsJson(array('number' => 1, 'state' => 'new'), );
        $I->seeResponseContainsJson(array('number' => 2, 'state' => 'open'), );

        $I->seeInDatabase('order', ['number' => 1, 'totalPrice' => 0, 'offLargeOrder' => NULL, 'state' => 'new', 'customerId' => 1]);
          }
    

    public function testGetNonExistingResource(ApiTester $I) {
        Authorisation::setAuthorisationToken($I);
        $I->sendGet('/orders/999');
        $I->seeResponseCodeIs(404);
    }

    public function testPutOrderState(ApiTester $I) {
        Authorisation::setAuthorisationToken($I);
        $I->sendPut('/orders/1/test');
        $I->sendGet('/orders/1');
        $I->seeResponseContainsJson(array('orderNumber' => 1, 'state' => 'test'), );
    }

    public function testPostNewOrder(ApiTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');
        Authorisation::setAuthorisationToken($I);
        // order number is auto increment (next number is 5)
        $I->sendPost('/orders', ['totalPrice' => 999, 'offLargeOrder' => NULL, 'state' => 'test', 'customerId' => 2]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200 Burde vært 201 ?
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(array('number' => 5, 'totalPrice' => 999, 'offLargeOrder' => NULL, 'state' => 'test', 'customerId' => 2));
        $I->seeInDatabase('order', ['number' => 5, 'totalPrice' => 999, 'offLargeOrder' => NULL, 'state' => 'test', 'customerId' => 2]);

    }



}
