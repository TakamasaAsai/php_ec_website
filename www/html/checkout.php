<?php
session_start();
require_once('Users.php');
$users = new Users();
require_once('functions.php');
//DBからid=1のユーザデータを取得し、名前、Depositを表示す処理
$usersId = 1;
$rows = "";
$deposit = "";
$userName = "";
if (isset($usersId)) {
    $rows = $users->FetchUsersById($usersId);
}
foreach ($rows as $row) {
    $userName = $row['user_name'];
    $deposit = $row['deposit'];
}
//カート内容を表示するためPOSTの値を受け取って変数に詰める
$name = isset($_POST['name']) ? h($_POST['name']) : '';
$price = isset($_POST['price']) ? h($_POST['price']) : '';
$count = isset($_POST['count']) ? h($_POST['count']) : '';
$total = 0;

//もし、sessionにproductsがあったら
if (!empty($_SESSION['products'])) {
    //$_SESSION['products']を$productsという変数にいれる
    $products = $_SESSION['products'];
    //$productsをforeachで回し、キー(商品名)と値（金額・個数）取得
    foreach ($products as $key => $product) {
        //既に商品がカートに入っているので、個数を足し算する
        //SESSION内の商品の個数
        $count = (int)$count + (int)$product['count'];
        $subtotal = (int)$product['price'] * (int)$product['count'];
        $total += (int)$subtotal;
    }
}
$remainingBalance = (int)$deposit - (int)$total;


$data = [
    'products' => $products,
    'userName' => $userName,
    'total' => $total,
    'deposit' => $deposit,
    'remainingBalance' => $remainingBalance,
    'usersId' => $usersId,
];

view('./checkout.html', $data);


