<?php
require_once ('db.php');

class Users extends DB
{
    public function FetchUsersById($usersId)
    {
        if (isset($usersId)) {
            $sql = "SELECT * FROM users WHERE user_id=?";
//      上で定義したsql文を実行する
            $array = array($usersId);
            $res = parent::executeSQL($sql, $array);
//      SQL文で取得してきた値を配列に変換する
            $rows = $res->fetchAll(PDO::FETCH_ASSOC);
//      全ての商品レコードを配列形式で返す
            return $rows;
        }
    }
}