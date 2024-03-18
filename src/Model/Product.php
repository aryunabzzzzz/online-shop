<?php

namespace Model;

use Entity\ProductEntity;

class Product extends Model
{
    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM products");
        $products = $stmt->fetchAll();

        if (!$products){
            return [];
        }

        $productsArr = [];
        foreach ($products as $product){
            $productsArr[] = new ProductEntity($product['id'], $product['name'], $product['description'], $product['price'], $product['image']);
        }

        return  $productsArr;
    }
}