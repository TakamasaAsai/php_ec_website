<?php
require_once('Orders.php');
$orders = new Orders();
//var_dump($_POST);
$orderId = $_POST['order_id'];
//全レコードを表示する処理
$orderDetail = $orders->SelectOrderProductAll($orderId);
//var_dump($orderDetail);
function view($template, array $data = [])
{
    extract($data);

    require $template;
}


$data = [
    'orderDetail' => $orderDetail,
];

view('./order-detail.html', $data);


