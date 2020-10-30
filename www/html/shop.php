<?php
require_once('Products.php');
require_once('functions.php');
$products = new Products();

//全レコードを表示する処理
$recordList = $products->SelectProductsAll();

$data = [
    'recordList' => $recordList,
];

view('./shop.html', $data);

