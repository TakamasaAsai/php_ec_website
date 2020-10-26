<?php
require_once ('Products.php');
$products =new Products();
require_once ('functions.php');
//新規登録処理
if (isset($_POST['submitEntry'])) {
    h($_POST['product_name']);
    h($_POST['price']);
    h($_POST['quantity']);
    h($_POST['image']);
    $products->InsertProducts();
}
function view($template)
{
    require $template;
}

view('./add-product.html');

