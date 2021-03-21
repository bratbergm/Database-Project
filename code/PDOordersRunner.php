<?php
require_once 'db/dbCredentials.php';
require_once 'PDOorders.php';

$orders = new PDOorders();
print_r($orders->runFetchAllQuery());
//print_r($orders->runFetchOrdersState('new'));
//print_r($orders->runUpdateOrderState('1', 'new'));