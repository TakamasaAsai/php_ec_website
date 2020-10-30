<?php
require_once('functions.php');
require_once('Products.php');
$products = new Products();

//全レコードを表示する処理
$recordList = $products->SelectProductsAll();
//削除処理
if (isset($_POST['delete'])) {
    $products->DeleteProducts($_POST['id']);
    header('Location: ./manage-product.php');
}


$data = [
    'recordList' => $recordList,
];

view('./manage-product.html', $data);
