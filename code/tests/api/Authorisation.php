<?php

/**
 * Copied from https://git.gvk.idi.ntnu.no/runehj/sample-rest-api-project 
 * Token is Customer
 */
class Authorisation
{
    public static function setAuthorisationToken(ApiTester $I) {
        $cookie = new Symfony\Component\BrowserKit\Cookie('auth_token', 'b6c45863875e34487ca3c155ed145efe12a74581e27befec5aa661b8ee8ca6dd');
        $I->getClient()->getCookieJar()->set($cookie);
    }

}