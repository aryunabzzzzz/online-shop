<?php

namespace Model;

class ProductOrder extends Model
{
    public function create(int $product_id, string $name, int $quantity, float $price)
    {
        $stmt = $this->pdo->prepare("INSERT INTO products_order (product_id, name, quantity, price) VALUES (:product_id, :name, :quantity, :price)");
        $stmt->execute(['product_id'=>$product_id, 'name'=>$name, 'quantity'=>$quantity, 'price'=>$price]);
    }

}