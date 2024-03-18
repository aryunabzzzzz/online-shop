<?php

namespace Model;

class OrderProduct extends Model
{
    public function create(string $order_id, int $product_id,  int $quantity, float $price)
    {
        $stmt = $this->pdo->prepare("INSERT INTO orders_products (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)");
        $stmt->execute(['order_id'=>$order_id, 'product_id'=>$product_id, 'quantity'=>$quantity, 'price'=>$price]);
    }

}