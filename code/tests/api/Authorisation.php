<?php

/**
 * Copied from https://git.gvk.idi.ntnu.no/runehj/sample-rest-api-project 
 * 
 */
class Authorisation
{
    // Customer
    public static function setCustomerToken(ApiTester $I) {
        $cookie = new Symfony\Component\BrowserKit\Cookie('auth_token', 'b6c45863875e34487ca3c155ed145efe12a74581e27befec5aa661b8ee8ca6dd');
        $I->getClient()->getCookieJar()->set($cookie);
    }
    // Customer rep
    public static function setCustomerRepToken(ApiTester $I) {
        $cookie = new Symfony\Component\BrowserKit\Cookie('auth_token', 'fbecd91f02f99f3d896f387283921118375de5624d0a4b5eb614d248479dfef4');
        $I->getClient()->getCookieJar()->set($cookie);
    }
    

}