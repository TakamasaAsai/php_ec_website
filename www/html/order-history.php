<?php
require_once('Orders.php');
$orders = new Orders();
//全レコードを表示する処理
$orderHistory = $orders->SelectOrderDataAll();
function view($template, array $data = [])
{
    extract($data);

    require $template;
}


$data = [
    'orderHistory' => $orderHistory,
];

view('./order-history.html', $data);


