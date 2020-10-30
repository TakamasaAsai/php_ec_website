<?php
require_once('functions.php');
require_once('Orders.php');
$orders = new Orders();
$orderId = $_POST['order_id'];
//全レコードを表示する処理
$orderDetail = $orders->SelectOrderProductAll($orderId);


$data = [
    'orderDetail' => $orderDetail,
];

view('./order-detail.html', $data);


