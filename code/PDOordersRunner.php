<?php
require_once 'db/dbCredentials.php';
require_once 'PDOorders.php';
require_once 'db/OrdersModel.php';


/**
 * This file is only for testing
 */

$resource = ([1, 1000, 'ord21', 'test2', 2]);
$orders = new OrderModel();
print_r($orders->createResource($resource));


/*
$orders = new PDOorders();
print_r($orders->runFetchAllQuery());
//print_r($orders->runFetchOrdersState('new'));
//print_r($orders->runUpdateOrderState('1', 'new'));
*/