<?php
//カート内商品をSESSIONから削除する処理
$delete_name = isset($_POST['delete_name']) ? htmlspecialchars($_POST['delete_name'], ENT_QUOTES, 'utf-8') : '';
session_start();
//unset()で削除ボタンを押した変数を破棄する
if ($delete_name != '') unset($_SESSION['products'][$delete_name]);
require_once('functions.php');
require_once('Products.php');
$productStock = new Products();
require_once('Carts.php');
//POSTで送られてきたカート内商品のデータを変数へ代入
$image = isset($_POST['image']) ? h($_POST['image']) : '';
$name = isset($_POST['name']) ? h($_POST['name']) : '';
$price = isset($_POST['price']) ? h($_POST['price']) : '';
$count = isset($_POST['count']) ? h($_POST['count']) : '';
$updateName = isset($_POST['update_quantity_name']) ? h($_POST['update_quantity_name']) : '';
$updateQuantity = isset($_POST['quantity']) ? h($_POST['quantity']) : '';
$addName = "";
$subtotal = "";
$total = 0;
$sessionAddCart = "";
//もし、カートに（session）に商品（products）が既にあり、カートに商品が追加されたら
if (isset($_SESSION['products']) && !empty($name)) {
    //$_SESSION['products']を$productsという変数にいれる
    $products = $_SESSION['products'];
    //$productsをforeachで回し、キー(商品名)と値（金額・個数）取得
    $cart = new Carts();
    $sessionAddCart = $cart->addCart($products, $productStock, $count, $name);
}
if (!empty($sessionAddCart)) {
    $count = $sessionAddCart['count'];
    $name = $sessionAddCart['name'];
    $price = $sessionAddCart['price'];
    $image = $sessionAddCart['image'];
    $addName = $sessionAddCart['stockAdd']['product_name'];
}
if (!empty($sessionAddCart['stockAdd']['quantity']) && $sessionAddCart['stockAdd']['quantity'] < $count){
    $error_message = 'Out of Stock';
}

if (isset($_SESSION['products']) && !empty($updateName)) {
    //$_SESSION['products']を$productsという変数にいれる
    $products = $_SESSION['products'];
    //$productsをforeachで回し、キー(商品名)と値（金額・個数）取得
    $cart = new Carts();
    $sessionUpdateCart = $cart->updateCart($products, $productStock, $updateName, $updateQuantity, $count);
}
if (!empty($sessionUpdateCart)) {
    $count = $sessionUpdateCart['count'];
    $name = $sessionUpdateCart['name'];
    $price = $sessionUpdateCart['price'];
    $image = $sessionUpdateCart['image'];
}
if (!empty($sessionUpdateCart['stock']['quantity']) && $sessionUpdateCart['stock']['quantity'] < $count){
    $error_message = 'Out of Stock';
}
//更新、追加それぞれのパターンで変更した値をこの中で＄_SESSIONに入れ直す
//配列に入れるには、$name,$count,$priceの値が取得できていることが前提なのでif文で空のデータを排除する
if ($name != '' && $count != '' && $price != '' && $image != '') {
    $_SESSION['products'][$name] = [
        'count' => $count,
        'price' => $price,
        'image' => $image
    ];
}

//$_SESSION['products']に値が入ってたら、$productsに配列として代入
$products = isset($_SESSION['products']) ? $_SESSION['products'] : [];
foreach ($products as $name => $product) {
    //各商品の小計を取得
    $subtotal = (int)$product['price'] * (int)$product['count'];
    //各商品の小計を$totalに足す
    $total+= (int)$subtotal;
}
function view($template, array $data = [])
{
    extract($data);

    require $template;
}


$data = [
    'products' => $products,
    'name' => $name,
    'updateName' => $updateName,
    'addName' => $addName,
    'error_message' => $error_message,
    'total' => $total,
    'count' => $count,
];

view('./cart.html', $data);

