<?php
require_once('Products.php');
$products = new Products();

//全レコードを表示する処理
$recordList = $products->SelectProductsAll();

function view($template, array $data = [])
{
    extract($data);

    require $template;
}


$data = [
    'recordList' => $recordList,
];

view('./index.html', $data);


