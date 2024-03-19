<?php

namespace Repository;

use Entity\ProductEntity;

class ProductRepository extends Repository
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
            $productsArr[] = $this->hydrate($product);
        }

        return  $productsArr;
    }

    public function hydrate(array $data): ProductEntity
    {
        return new ProductEntity($data['id'], $data['name'], $data['description'], $data['price'], $data['image']);
    }
}