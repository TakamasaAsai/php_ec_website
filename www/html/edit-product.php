<?php
require_once('functions.php');
require_once('Products.php');
$products = new Products();
//更新処理
if (isset($_POST['submitUpdate'])) {
    h($_POST['product_name']);
    h($_POST['price']);
    h($_POST['quantity']);
    $products->UpdateProducts();
}
$productId = $_POST['product_id'];
$rows = "";
if (isset($productId)) {
    $rows = $products->FetchProductsById($productId);
}
function view($template, array $data = [])
{
    extract($data);

    require $template;
}


$data = [
    'rows' => $rows,
];

view('./edit-product.html', $data);

