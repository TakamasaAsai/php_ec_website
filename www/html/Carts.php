<?php


class Carts
{
    public function addCart($products, $count, $name)
    {
        foreach ($products as $key => $product) {
            //もし、カートの商品とPOSTで受け取った商品名が一致したら、
            if ($key == $name) {
                //既に商品がカートに入っているので、個数を足し算する
                //SESSION内の商品の個数
                $count = (int)$count + (int)$product['count'];
                return $count;
            }
        }
    }
    public function updateCart($products, $updateQuantity, $name)
    {
        foreach ($products as $key => $product) {
            //もし、カートの商品とupdateNameで受け取った商品名が一致したら、
            if ($key == $name) {
                //既に商品がカートに入っているので、個数を足し算する
                //SESSION内の商品の個数
                $count = (int)$updateQuantity;
                return $count;
            }
        }
    }
}