<?php
require_once('Products.php');
$products = new Products();
require_once('functions.php');
$productName = (string)filter_input(INPUT_POST, 'product_name');
$price = (int)filter_input(INPUT_POST, 'price');
$quantity = (int)filter_input(INPUT_POST, 'quantity');
$image = (string)filter_input(INPUT_POST, 'image');

//新規登録処理
if (isset($_POST['submitEntry'])) {
    $products->InsertProducts($productName, $price, $quantity, $image);
}

view('./add-product.html');

