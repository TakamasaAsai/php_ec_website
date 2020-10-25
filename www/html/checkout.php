<?php
session_start();
require_once('Users.php');
$users = new Users();
//DBからid=1のユーザデータを取得し、名前、Depositを表示す処理
$usersId = 1;
$rows = "";
$deposit = "";
if (isset($usersId)) {
    $rows = $users->FetchUsersById($usersId);
}
foreach ($rows as $row) {
    $userName = $row['user_name'];
    $deposit = $row['deposit'];
}
//カート内容を表示するためPOSTの値を受け取って変数に詰める
$image = isset($_POST['image']) ? htmlspecialchars($_POST['image'], ENT_QUOTES, 'utf-8') : '';
$name = isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES, 'utf-8') : '';
$price = isset($_POST['price']) ? htmlspecialchars($_POST['price'], ENT_QUOTES, 'utf-8') : '';
$count = isset($_POST['count']) ? htmlspecialchars($_POST['count'], ENT_QUOTES, 'utf-8') : '';
$total = isset($_POST['total']) ? htmlspecialchars($_POST['total'], ENT_QUOTES, 'utf-8') : '';
$remainingBalance = (int)$deposit - (int)$total;

//もし、sessionにproductsがあったら
if (!empty($_SESSION['products'])) {
    //$_SESSION['products']を$productsという変数にいれる
    $products = $_SESSION['products'];
    //$productsをforeachで回し、キー(商品名)と値（金額・個数）取得
    foreach ($products as $key => $product) {
        //もし、キーとPOSTで受け取った商品名が一致したら、
        if ($key == $name) {
            //既に商品がカートに入っているので、個数を足し算する
            //SESSION内の商品の個数
            $count = (int)$count + (int)$product['count'];
            $subtotal = (int)$product['price'] * (int)$product['count'];
            $total+= (int)$subtotal;
        }
    }
}
function view($template, array $data = [])
{
    extract($data);

    require $template;
}


$data = [
    'products' => $products,
    'userName' => $userName,
    'total' => $total,
    'deposit' => $deposit,
    'remainingBalance' => $remainingBalance,
    'usersId' => $usersId,
];

view('./checkout.html', $data);


