<?php

class UserProduct extends Model
{
    public function create($user_id, $product_id, $quantity)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users_products (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
        $stmt->execute(['user_id'=>$user_id, 'product_id'=>$product_id, 'quantity'=>$quantity]);
    }

    public function updateQuantity($user_id, $product_id, $quantity)
    {
        $stmt = $this->pdo->prepare("UPDATE users_products SET quantity = (quantity + :quantity) WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id'=>$user_id, 'product_id'=>$product_id, 'quantity'=>$quantity]);
    }

    public function getOneByUserIdProductId($user_id, $product_id)
    {
        $stmt = $this->pdo->prepare("SELECT user_id, product_id FROM users_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id'=>$user_id, 'product_id'=>$product_id]);
        $userProduct = $stmt->fetch();

        return $userProduct;
    }
}