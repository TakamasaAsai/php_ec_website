<?php
require_once('DB.php');

class Orders extends DB
{

    public function SelectOrderDataAll()
    {
        $sql = "SELECT * FROM order_data";
        $res = parent::executeSQL($sql, null);
        $rows = $res->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function SelectOrderProductAll($orderId)
    {
        $sql = "SELECT * FROM order_products WHERE order_id=?";
        $array = array($orderId);
        $res = parent::executeSQL($sql, $array);
        $rows = $res->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
}