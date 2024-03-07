<?php

class Product
{
    public function getAll()
    {
        $pdo = new PDO("pgsql:host=db; port=5432; dbname=laravel","root", "root");
        $stmt = $pdo->query("SELECT * FROM products");
        $products = $stmt->fetchAll();

        return $products;
    }
}