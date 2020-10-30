<?php
require_once('functions.php');
require_once('Orders.php');
$orders = new Orders();
//    extract($data);を説明できるようにする
//全レコードを表示する処理
$orderHistory = $orders->SelectOrderDataAll();


$data = [
    'orderHistory' => $orderHistory,
];

view('./order-history.html', $data);


