<?php
require_once 'db/dbCredentials.php';
require_once 'db/OrdersModel.php';

$model = new OrderModel();
//print($model->createOrdersDoc() . "\n");
print($model->createOrdersItemsDoc() . "\n");