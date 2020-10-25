<?php
require_once ('Products.php');
$products =new Products();
//新規登録処理
if (isset($_POST['submitEntry'])) {
    $products->InsertProducts();
}
function view($template)
{
    require $template;
}

view('./add-product.html');

