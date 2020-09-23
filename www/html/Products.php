<?php
require_once ('db.php');

class Products extends DB
{
    //productsテーブルのCRUD担当
    public function SelectProductsAll()
    {
//      全ての商品レコード取得
        $sql = "SELECT * FROM products";
//      上で定義したsql文を実行する
        $res = parent::executeSQL($sql, null);
//      SQL文で取得してきた値を配列に変換する
        $rows = $res->fetchAll(PDO::FETCH_ASSOC);
//      全ての商品レコードを配列形式で返す
        return $rows;
    }

    public function FetchProductsById($productId)
    {
        if (isset($productId)) {
            $sql = "SELECT * FROM products WHERE product_id=?";
//      上で定義したsql文を実行する
            $array = array($productId);
            $res = parent::executeSQL($sql, $array);
//      SQL文で取得してきた値を配列に変換する
            $rows = $res->fetchAll(PDO::FETCH_ASSOC);
//      全ての商品レコードを配列形式で返す
            return $rows;
        }
    }

    public function InsertProducts()
    {
        $sql = "INSERT INTO products (product_name, price, quantity) VALUES(?,?,?)";
        $array = array($_POST['product_name'], $_POST['price'], $_POST['quantity']);
        parent::executeSQL($sql, $array);
    }

    public function UpdateProducts()
    {
        $sql = "UPDATE products SET product_name=?, price=?, quantity=? WHERE product_id=?";
        //array関数の引数の順番に注意する
        $array = array($_POST['product_name'], $_POST['price'], $_POST['quantity']);
        parent::executeSQL($sql, $array);
    }

    public function GoodsNameForUpdate($GoodsID)
    {                               //③
        return $this->FieldValueForUpdate($GoodsID, "GoodsName");
    }

    public function PriceForUpdate($GoodsID)
    {                                   //④
        return $this->FieldValueForUpdate($GoodsID, "Price");
    }

    private function FieldValueForUpdate($GoodsID, $field)
    {                     //⑤
        //private関数　上の2つの関数で使用している
        $sql = "SELECT {$field} FROM goods WHERE GoodsID=?";
        $array = array($GoodsID);
        $res = parent::executeSQL($sql, $array);
        $rows = $res->fetch(PDO::FETCH_NUM);
        return $rows[0];
    }


    public function DeleteProducts($GoodsID)
    {
        $sql = "DELETE FROM products WHERE GoodsID=?";
        $array = array($GoodsID);
        parent::executeSQL($sql, $array);
    }

    public function DefinePages()
    {
        //必要なページ数を求める
        //goodsテーブルから合計の行数を取ってくる
        $sql = "SELECT COUNT(*) AS count FROM goods";
        $count = parent::executeSQL($sql, null);
        $total_count = $count->fetch(PDO::FETCH_ASSOC);
        //totalの行数を1ページの最大表示個数で割って少数点が出たら切り上げceil()関数
        $pages = ceil($total_count['count'] / max_view);
        return $pages;
    }

    public function FetchGoods($offset, $column, $searchItem)
    {
//      リファクタ後
//      ここからAscの条件、ユーザがID、名前、金額のどれかで昇順を選択した時
        if ($column == 'idAsc') {
            $columnAsc = 'GoodsID';
        }
        if ($column == 'nameAsc') {
            $columnAsc = 'CAST(GoodsName AS CHAR)';
        }
        if ($column == 'priceAsc') {
            $columnAsc = 'Price';
        }
//      ここからDescの条件、ユーザがID、名前、金額のどれかでが降順を選択した時
        if ($column == 'idDesc') {
            $columnDesc = 'GoodsID';
        }
        if ($column == 'nameDesc') {
            $columnDesc = 'CAST(GoodsName AS CHAR)';
        }
        if ($column == 'priceDesc') {
            $columnDesc = 'Price';
        }


//  ①検索＋昇順ソート、検索＋降順ソート、検索のみ
        if (isset($columnAsc) && isset($searchItem)) {
//      【検索＋昇順ソート】指定のカラムの昇順で商品レコードを5行取得したいので、SELECTを使いSQL文を定義
            $sql = "SELECT * FROM `goods` WHERE GoodsName LIKE :name ORDER BY " . $columnAsc . " ASC LIMIT :first, 5";
            $fetchAssoc = parent::executeFetchAssocSearchSQL($sql, $offset, $searchItem);
            return $fetchAssoc;
        }
        if (isset($columnDesc) && isset($searchItem)) {
//      【検索＋降順ソート】指定のカラムの降順で商品レコードを5行取得したいので、SELECTを使いSQL文を定義
            $sql = "SELECT * FROM `goods` WHERE GoodsName LIKE :name ORDER BY " . $columnDesc . " DESC LIMIT :first, 5";
            $fetchAssoc = parent::executeFetchAssocSearchSQL($sql, $offset, $searchItem);
            return $fetchAssoc;
        }
        if (isset($searchItem) && !isset($columnDesc) && !isset($columnAsc)) {
//      【検索のみ】
            $sql = "SELECT * FROM `goods` WHERE GoodsName LIKE :name LIMIT :first, 5";
//      上で定義したsql文を今見ているページ数を引数にとり実行する
            $fetchAssoc = parent::executeFetchAssocSearchSQL($sql, $offset, $searchItem);
            return $fetchAssoc;
        }

//  ②各カラムの昇順ソート、各カラムの降順ソート、ID昇順（デフォルトの設定）
        if (isset($columnAsc) && !isset($searchItem)) {
//      【各カラムの昇順ソート】指定のカラムの昇順で商品レコードを5行取得したいので、SELECTを使いSQL文を定義
            $sql = "SELECT * FROM `goods` WHERE GoodsName ORDER BY " . $columnAsc . " ASC LIMIT :first, 5";
            $fetchAssoc = parent::executeFetchAssocSQL($sql, $offset);
            return $fetchAssoc;
        }
        if (isset($columnDesc) && !isset($searchItem)) {
//      【各カラムの降順ソート】指定のカラムの降順で商品レコードを5行取得したいので、SELECTを使いSQL文を定義
            $sql = "SELECT * FROM `goods` WHERE GoodsName ORDER BY " . $columnDesc . " DESC LIMIT :first, 5";
            $fetchAssoc = parent::executeFetchAssocSQL($sql, $offset);
            return $fetchAssoc;
        }
        if (!isset($column) && !isset($searchItem)) {
//      【ID昇順（デフォルトの設定）】IDの昇順で商品レコードを5行取得したいので、SELECTを使いSQL文を定義
            $sql = "SELECT * FROM `goods` ORDER BY GoodsID LIMIT :first, 5";
//      上で定義したsql文を今見ているページ数を引数にとり実行する
            $fetchAssoc = parent::executeFetchAssocSQL($sql, $offset);
            return $fetchAssoc;
//      この$fetchAssocには商品レコード5行分を格納した配列が入っているのでこれをView側で表示する
        }

    }

}


