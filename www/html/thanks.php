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

   var_dump($products);
//購入商品のIDから在庫数をDBから取ってくる
//$updatedStock = 在庫数-購入数
//$updatedStockでDBの個数を更新する

   //売上データを新規登録
//userのデポジットを更新
//var_dump($_POST);
if (isset($_POST['confirm'])) {
    $productClass->InsertSalesData();
    $users->UpdateDeposit();
    //salesのid取得
    $salesId = $productClass->FetchLastInsertId();
    var_dump($_SESSION);
    //sales_productsテーブル
    foreach($products as $key => $product){
        $productClass->InsertSalesProducts($salesId,$key,$product);
        $productStock = $productClass->SelectProductsByName($key);
        $updatedStock = $productStock[2] - $product['count'];
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