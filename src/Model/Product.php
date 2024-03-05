<?php

class Product
{
    public function getOneById($id)
    {
        $pdo = new PDO("pgsql:host=db; port=5432; dbname=laravel","root", "root");
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id'=>$id]);
        $id = $stmt->fetch();

        return ($id);
    }

    public function getAll()
    {
        $pdo = new PDO("pgsql:host=db; port=5432; dbname=laravel","root", "root");
        $stmt = $pdo->query("SELECT * FROM products");
        $products = $stmt->fetchAll();

        return $products;
    }
}