<?php
//問題4つの役割をこのファイルでやってしまっている
//4つのファイルに分割ができる
//1.商品をカートに追加➡Redirectで4.の商品表示に遷移
//2.カートの商品を削除➡Redirectで4.の商品表示に遷移
//3.カートの数量を変更➡Redirectで4.の商品表示に遷移
//4.カートの商品を表示
//カート内商品をSESSIONから削除する処理
session_start();
require_once('functions.php');
require_once('Products.php');
$productStock = new Products();
$error_message = $_SESSION['error_message'];
$subtotal = "";
$total = 0;
$stock = 0;

//$_SESSION['products']に値が入ってたら、$productsに配列として代入
//カートの中身をループで各変数に代入
$products = isset($_SESSION['products']) ? $_SESSION['products'] : [];
foreach ($products as $name => $product) {
    //各商品の小計を取得
    $subtotal = (int)$product['price'] * (int)$product['count'];
    //各商品の小計を$totalに足す
    $total += (int)$subtotal;
    $count = (int)$product['count'];
    $productId = (int)$product['product_id'];
    if (!empty($product['error_message'])){
        $error_message = $product['error_message'];
    }
}


$data = [
    'products' => $products,
    'name' => $name,
    'error_message' => $error_message,
    'total' => $total,
    'count' => $count,
];

view('./cart.html', $data);

