<?php

class ProductModel
{
    public function getOneById($id)
    {
        $pdo = new PDO("pgsql:host=db; port=5432; dbname=laravel","root", "root");
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id'=>$id]);
        $id = $stmt->fetch();

        return ($id);
    }

    public function addIntoTable($user_id, $product_id, $quantity)
    {
        $pdo = new PDO("pgsql:host=db; port=5432; dbname=laravel","root", "root");
        $stmt = $pdo->prepare("INSERT INTO users_products (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
        $stmt->execute(['user_id'=>$user_id, 'product_id'=>$product_id, 'quantity'=>$quantity]);
    }

    public function updateTable($user_id, $product_id, $quantity)
    {
        $pdo = new PDO("pgsql:host=db; port=5432; dbname=laravel","root", "root");
        $pdo->query("UPDATE users_products SET quantity = (quantity + $quantity) WHERE user_id = $user_id AND product_id = $product_id");

    }

    public function checkTable($user_id, $product_id)
    {
        $pdo = new PDO("pgsql:host=db; port=5432; dbname=laravel","root", "root");
        $stmt = $pdo->query("SELECT user_id, product_id FROM users_products WHERE user_id = $user_id AND product_id = $product_id");
        $test = $stmt->fetch();

        return $test;
    }
}