<?php

namespace Model;

use Entity\ProductEntity;
use Entity\UserEntity;
use Entity\UserProductEntity;

class UserProduct extends Model
{
    public function create(int $user_id, int $product_id, int $quantity): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO users_products (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
        $stmt->execute(['user_id'=>$user_id, 'product_id'=>$product_id, 'quantity'=>$quantity]);
    }

    public function increaseQuantity(int $user_id, int $product_id): void
    {
        $stmt = $this->pdo->prepare("UPDATE users_products SET quantity = (quantity + 1) WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id'=>$user_id, 'product_id'=>$product_id]);
    }

    public function getOneByUserIdProductId(int $user_id, int $product_id): UserProductEntity|null
    {
        $stmt = $this->pdo->prepare("SELECT up.id AS id, up.quantity, 
        u.id AS user_id, u.name AS user_name, u.email, u.password, 
        p.id AS product_id, p.name AS product_name, p.description, p.price, p.image
        FROM users_products up 
        JOIN users u ON up.user_id = u.id 
        JOIN products p ON up.product_id = p.id
        WHERE user_id =:user_id AND product_id =:product_id
        "
        );
        $stmt->execute(['user_id'=>$user_id, 'product_id'=>$product_id]);
        $userProduct = $stmt->fetch();

        if(!$userProduct){
            return null;
        }

        return new UserProductEntity($userProduct['id'],
            new UserEntity($userProduct['user_id'], $userProduct['user_name'], $userProduct['email'], $userProduct['password']),
            new ProductEntity($userProduct['product_id'], $userProduct['product_name'], $userProduct['description'], $userProduct['price'], $userProduct['image']),
            $userProduct['quantity']);

    }

    public function getAllByUserId(int $user_id): array
    {
        $stmt = $this->pdo->prepare("SELECT up.id AS id, up.quantity, 
        u.id AS user_id, u.name AS user_name, u.email, u.password, 
        p.id AS product_id, p.name AS product_name, p.description, p.price, p.image
        FROM users_products up 
        JOIN users u ON up.user_id = u.id 
        JOIN products p ON up.product_id = p.id
        WHERE user_id =:user_id
        "
        );

        $stmt->execute(['user_id' => $user_id]);
        $userProducts = $stmt->fetchAll();

        if (!$userProducts){
            return [];
        }

        $userProductsArr = [];

        foreach ($userProducts as $userProduct){
            $userProductsArr[] = new UserProductEntity($userProduct['id'],
            new UserEntity($userProduct['user_id'], $userProduct['user_name'], $userProduct['email'], $userProduct['password']),
            new ProductEntity($userProduct['product_id'], $userProduct['product_name'], $userProduct['description'], $userProduct['price'], $userProduct['image']),
            $userProduct['quantity']);
        }

        return $userProductsArr;
    }

    public function decreaseQuantity(int $user_id, int $product_id): void
    {
        $stmt = $this->pdo->prepare("UPDATE users_products SET quantity = (quantity - 1) WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id'=>$user_id, 'product_id'=>$product_id]);
    }

    public function delete(int $user_id, int $product_id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM users_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id'=>$user_id, 'product_id'=>$product_id]);
    }

    public function deleteAllByUserId(int $user_id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM users_products WHERE user_id = :user_id");
        $stmt->execute(['user_id'=>$user_id]);
    }
}