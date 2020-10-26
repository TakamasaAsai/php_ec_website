<?php


class Carts
{
    public function addCart($products,$productStock,$count,$name)
    {
        foreach ($products as $key => $product) {
            //もし、カートの商品とPOSTで受け取った商品名が一致したら、
            if ($key == $name) {
                //既に商品がカートに入っているので、個数を足し算する
                //SESSION内の商品の個数
                $count = (int)$count + (int)$product['count'];
                $price = $product['price'];
                $image = $product['image'];
                $stockAdd = $productStock->SelectProductsByName($name);
                return ['stockAdd'=>$stockAdd,'count'=>$count,'name'=>$name,'price'=>$price,'image'=>$image];
            }
        }
    }
    public function updateCart($products,$productStock,$updateName,$updateQuantity,$count)
    {
        foreach ($products as $key => $product) {
            //もし、カートの商品とupdateNameで受け取った商品名が一致したら、
            if ($key == $updateName) {
                //既に商品がカートに入っているので、個数を足し算する
                //SESSION内の商品の個数
                $count = (int)$count + (int)$updateQuantity;
                $name = $updateName;
                $price = $product['price'];
                $image = $product['image'];
                $stock = $productStock->SelectProductsByName($updateName);
                return ['stock'=>$stock,'count'=>$count,'name'=>$name,'price'=>$price,'image'=>$image];;
            }
        }
    }
}