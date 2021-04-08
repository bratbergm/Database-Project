<?php

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
              $I->sendGet('/orders?state=new');
              $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
              $I->seeResponseIsJson();

  //            $I->assertEquals(2, count(json_decode($I->grabResponse())));
              $I->seeResponseContainsJson(array('number' => 1, 'state' => 'new'), );
              $I->seeResponseContainsJson(array('number' => 2, 'state' => 'open'), );
          }
    

   



}
