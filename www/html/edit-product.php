<?php
require_once('functions.php');
require_once('Products.php');
$products = new Products();
//更新処理
//XSSの対策はユーザが入力した内容をフロントエンドで表示する時の対策
//SQLインジェクションの対策はDBに間違った値を入力することを防ぐ対策
//h関数は実行するだけでは値は変わらない、変数に代入しないと使えない
//修正の際にこのシステムではどのようにSQLインジェクションの対応をしているか回答できるようにする。
$productName = (string)filter_input(INPUT_POST, 'product_name');
$price = (int)filter_input(INPUT_POST, 'price');
$quantity = (int)filter_input(INPUT_POST, 'quantity');
$productId = (int)filter_input(INPUT_POST, 'product_id');

if (isset($_POST['submitUpdate'])) {
    $products->UpdateProducts($productName, $price, $quantity, $productId);
}
$rows = "";
if (isset($productId)) {
    $rows = $products->FetchProductsById($productId);
}


$data = [
    'rows' => $rows,
];

view('./edit-product.html', $data);

