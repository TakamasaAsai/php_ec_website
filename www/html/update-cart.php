<?php
session_start();
require_once('functions.php');
require_once('Products.php');
$productStock = new Products();
require_once('Carts.php');
//POSTで送られてきたカート内商品のデータを変数へ代入
//POSTで受け取ったものは値のバリデーションを行ってからDBに入れるSQL文のパラメータとして渡す
$productId = (int)filter_input(INPUT_POST, 'product_id');
$updateQuantity = (int)filter_input(INPUT_POST, 'quantity');
$stock = "";
$count = "";
$name = "";
$price = "";
$image = "";
//DBからProduct_Idをもとに追加された商品のデータを取ってくる
$rows = $productStock->FetchProductsById($productId);

foreach ($rows as $row) {
    $name = $row['product_name'];
    $price = $row['price'];
    $stock = $row['quantity'];
    $image = $row['image'];
}
//もし、カートに（session）に商品（products）が既にあり、カートに商品が追加されたら
if (!empty($_SESSION['products'])) {
    //$_SESSION['products']を$productsという変数にいれる
    $products = $_SESSION['products'];
    //$productsをforeachで回し、キー(商品名)と値（金額・個数）取得
    $cart = new Carts();
    $count = $cart->updateCart($products, $updateQuantity, $name);
}
if ($stock < $count) {
    $error_message = 'Out of Stock';
    $_SESSION['error_message'] = $error_message;
    $_SESSION['error_updateName'] = $name;
}
if ($stock >= $count && $name == $_SESSION['error_updateName']) {
    unset($_SESSION['error_message'], $_SESSION['error_updateName'],$_SESSION['error_addName']);
}
//更新、追加それぞれのパターンで変更した値をこの中で＄_SESSIONに入れ直す
//配列に入れるには、$name,$count,$priceの値が取得できていることが前提なのでif文で空のデータを排除する
if ($name != '' && $count != '' && $price != '' && $image != '') {
    $_SESSION['products'][$name] = [
        'count' => $count,
        'price' => $price,
        'image' => $image,
        'product_id' => $productId,
        'error_message' =>  isset($error_message) ? $error_message:''
    ];
}


header('Location: ./cart.php');
