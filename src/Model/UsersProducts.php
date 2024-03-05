<?php

class UsersProducts
{
    public function create($user_id, $product_id, $quantity)
    {
        $pdo = new PDO("pgsql:host=db; port=5432; dbname=laravel","root", "root");
        $stmt = $pdo->prepare("INSERT INTO users_products (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
        $stmt->execute(['user_id'=>$user_id, 'product_id'=>$product_id, 'quantity'=>$quantity]);
    }

    public function updateQuantity($user_id, $product_id, $quantity)
    {
        $pdo = new PDO("pgsql:host=db; port=5432; dbname=laravel","root", "root");
        $stmt = $pdo->prepare("UPDATE users_products SET quantity = (quantity + :quantity) WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id'=>$user_id, 'product_id'=>$product_id, 'quantity'=>$quantity]);
    }

    public function getOneByUserIdProductId($user_id, $product_id)
    {
        $pdo = new PDO("pgsql:host=db; port=5432; dbname=laravel","root", "root");
        $stmt = $pdo->prepare("SELECT user_id, product_id FROM users_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id'=>$user_id, 'product_id'=>$product_id]);
        $userProduct = $stmt->fetch();

        return $userProduct;
    }
}