<?php
require_once('DB.php');
$db = new DB();
$pdo = $db->Connectdb();
require_once('Products.php');
require_once('functions.php');
$productClass = new Products();
require_once('Users.php');
$users = new Users();
session_start();
$products = isset($_SESSION['products']) ? $_SESSION['products'] : [];
$remainingBalance = (int)filter_input(INPUT_POST, 'remainingBalance');
$usersId = (int)filter_input(INPUT_POST, 'usersId');
$total = (int)filter_input(INPUT_POST, 'total');
$userName = (string)filter_input(INPUT_POST, 'userName');
//売上データを新規登録
//userのデポジットを更新
if (isset($_POST['confirm'])) {
    $productClass->InsertOrderData($total, $userName, $usersId);
    $users->UpdateDeposit($remainingBalance, $usersId);
    //salesのid取得
    $orderId = $productClass->FetchLastInsertId();
    //sales_productsテーブル
    foreach ($products as $key => $product) {
        $productClass->InsertOrderProducts($orderId, $key, $product);
        $productStock = $productClass->SelectProductsByName($key);
        $updatedStock = $productStock['quantity'] - $product['count'];
        $productClass->UpdateQuantity($updatedStock, $productStock);
    }
}
unset($_SESSION['products']);


$data = [
    'data' => 'test',
];

view('./thanks.html', $data);