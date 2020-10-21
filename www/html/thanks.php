<?php
//var_dump($_POST);
require_once('db.php');
$db = new DB();
$pdo = $db->Connectdb();
require_once('Products.php');
$productClass = new Products();
require_once('Users.php');
$users = new Users();

   session_start();
   $products = isset($_SESSION['products'])? $_SESSION['products']:[];

//   var_dump($products);
//購入商品のIDから在庫数をDBから取ってくる
//$updatedStock = 在庫数-購入数
//$updatedStockでDBの個数を更新する

   //売上データを新規登録
//userのデポジットを更新
//var_dump($_POST);
if (isset($_POST['confirm'])) {
    $productClass->InsertOrderData();
    $users->UpdateDeposit();
    //salesのid取得
    $orderId = $productClass->FetchLastInsertId();
//    var_dump($_SESSION);
    //sales_productsテーブル
    foreach($products as $key => $product){
        $productClass->InsertOrderProducts($orderId,$key,$product);
        $productStock = $productClass->SelectProductsByName($key);
        var_dump($productStock);
        $updatedStock = $productStock['quantity'] - $product['count'];
        var_dump($updatedStock);
        $productClass->UpdateQuantity($updatedStock, $productStock);
    }
}
unset($_SESSION['products']);

//テンプレート表示
function view($template, array $data = [])
{
    extract($data);

    require $template;
}


$data = [
    'data' => 'test',
];

view('./thanks.html', $data);