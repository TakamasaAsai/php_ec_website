<?php
require_once('functions.php');
require_once('Products.php');
$products = new Products();

//全レコードを表示する処理
$recordList = $products->SelectProductsAll();


$data = [
    'recordList' => $recordList,
];

view('./index.html', $data);


