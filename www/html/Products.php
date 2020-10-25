<?php
require_once('DB.php');

class Products extends DB
{
    public function SelectProductsAll()
    {
        $sql = "SELECT * FROM products";
        $res = parent::executeSQL($sql, null);
        $rows = $res->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function SelectProductsByName($key)
    {
        $sql = "SELECT * FROM products WHERE product_name =?";
        $array = array($key);
        $res = parent::executeSQL($sql, $array);
        $rows = $res->fetch(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function FetchProductsById($productId)
    {
        if (isset($productId)) {
            $sql = "SELECT * FROM products WHERE product_id=?";
            $array = array($productId);
            $res = parent::executeSQL($sql, $array);
            $rows = $res->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        }
    }

    public function InsertProducts()
    {
        $sql = "INSERT INTO products (product_name, price, quantity, image) VALUES(?,?,?,?)";
        $array = array($_POST['product_name'], $_POST['price'], $_POST['quantity'], $_POST['image']);
        parent::executeSQL($sql, $array);
    }

    public function UpdateProducts()
    {
        $sql = "UPDATE products SET product_name=?, price=?, quantity=? WHERE product_id=?";
        $array = array($_POST['product_name'], $_POST['price'], $_POST['quantity'], $_POST['product_id']);
        parent::executeSQL($sql, $array);
    }

    public function UpdateQuantity($updatedStock, $productStock)
    {
        $sql = "UPDATE products SET quantity=? WHERE product_id=?";
        $array = array($updatedStock, $productStock['product_id']);
        parent::executeSQL($sql, $array);
    }

    public function DeleteProducts($productId)
    {
        $sql = "DELETE FROM products WHERE product_id=?";
        $array = array($productId);
        parent::executeSQL($sql, $array);
    }

    public function InsertOrderData()
    {
        $date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO order_data (order_date, total, user_name, users_id) VALUES(?,?,?,?)";
        $array = array($date, $_POST['total'], $_POST['userName'], $_POST['usersId']);
        parent::executeSQL($sql, $array);
    }

    public function InsertOrderProducts($orderId, $key, $product)
    {
        $sql = "INSERT INTO order_products (order_id, product_name, quantity, price) VALUES(?,?,?,?)";
        $array = array($orderId[0], $key, $product['count'], $product['price']);
        parent::executeSQL($sql, $array);
    }

    public function FetchLastInsertId()
    {
        $sql = "SELECT MAX(id) FROM order_data";
        $lastInsertId = parent::executeSQL($sql, null);
        $rows = $lastInsertId->fetchAll(PDO::FETCH_NUM);
        return $rows[0];
    }

}


