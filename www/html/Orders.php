<?php
require_once ('DB.php');

class Orders extends DB
{

    public function SelectOrderDataAll(){
//      全ての商品レコード取得
        $sql = "SELECT * FROM order_data";
//      上で定義したsql文を実行する
        $res = parent::executeSQL($sql, null);
//      SQL文で取得してきた値を配列に変換する
        $rows = $res->fetchAll(PDO::FETCH_ASSOC);
//      全ての商品レコードを配列形式で返す
        return $rows;
    }
    public function SelectOrderProductAll($orderId){
//      全ての商品レコード取得
        $sql = "SELECT * FROM order_products WHERE order_id=?";
        $array = array($orderId);
//      上で定義したsql文を実行する
        $res = parent::executeSQL($sql, $array);
//      SQL文で取得してきた値を配列に変換する
        $rows = $res->fetchAll(PDO::FETCH_ASSOC);
//      全ての商品レコードを配列形式で返す
        return $rows;
    }
}