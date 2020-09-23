<?php

class DB
{
    private $USER = "root";
    private $PW = "secret";
    private $dns = "mysql:dbname=php_ec_web;host=db;charset=utf8";

    public function Connectdb()
    {
        try {
            $pdo = new PDO($this->dns, $this->USER, $this->PW);
            return $pdo;
        } catch (Exception $e) {
            var_dump($e->getMessage());
            echo "MySQL への接続に失敗しました。";
            return false;
        }
    }
    protected function executeSQL($sql, $array)
    {
        try {
            if (!$pdo = $this->Connectdb()) return false;
            $stmt = $pdo->prepare($sql);
            $stmt->execute($array);
            return $stmt;
        } catch (Exception $e) {
            var_dump($e->getMessage());
            return false;
        }
    }
}

?>