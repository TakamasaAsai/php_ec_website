<?php
require_once('Products.php');
$products = new Products();

//全レコードを表示する処理
$recordList = $products->SelectProductsAll();
//削除処理
if (isset($_POST['delete'])) {
    $products->DeleteProducts($_POST['id']);
}
function view($template, array $data = [])
{
    extract($data);

    require $template;
}


$data = [
    'recordList' => $recordList,
];

view('./shop.html', $data);
?>
