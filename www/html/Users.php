<?php
require_once('DB.php');

class Users extends DB
{
    public function FetchUsersById($usersId)
    {
        if (isset($usersId)) {
            $sql = "SELECT * FROM users WHERE user_id=?";
            $array = array($usersId);
            $res = parent::executeSQL($sql, $array);
            $rows = $res->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        }
    }

    public function UpdateDeposit()
    {
        $sql = "UPDATE users SET deposit=? WHERE user_id=?";
        $array = array($_POST['remainingBalance'], $_POST['usersId']);
        parent::executeSQL($sql, $array);
    }
}