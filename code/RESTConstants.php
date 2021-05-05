<?php

/**
 * Class RESTConstants class for application constants.
 */
class RESTConstants
{
    // HTTP method names
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';

    // HTTP status codes
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_ACCEPTED = 202;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_NOT_IMPLEMENTED = 501;

    const ENDPOINT_ORDERS = 'orders';
    const ENDPOINT_SKIS = 'skis';
    const ENDPOINT_SKITYPES = 'skitypes';
    const ENDPOINT_PLAN = 'plans';

    const ENDPOINT_PUBLIC = 'public';
    

    // Tokens 
    const TOKEN_PUBLIC = 'efa1f375d76194fa51a3556a97e641e61685f914d446979da50a551a4333ffd7';
    const TOKEN_STOREKEEPER = 'd5367aea1c17343b6c380f774b81a8d7d5e33c43dc445fdc8a6f884723694f3d';
    const TOKEN_CUSTOMERREP = 'fbecd91f02f99f3d896f387283921118375de5624d0a4b5eb614d248479dfef4';
    const TOKEN_CUSTOMER = 'b6c45863875e34487ca3c155ed145efe12a74581e27befec5aa661b8ee8ca6dd';

    const API_URI = 'http://localhost/dbproject';
}
