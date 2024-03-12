<?php

namespace Model;

class Product extends Model
{
    public function getAll(): array|false
    {
        $stmt = $this->pdo->query("SELECT * FROM products");
        $products = $stmt->fetchAll();

        return $products;
    }
}