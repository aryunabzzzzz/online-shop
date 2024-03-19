<?php

namespace Model;

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

    public function getOneByUserIdProductId(int $user_id, int $product_id): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id'=>$user_id, 'product_id'=>$product_id]);
        return $stmt->fetch();
    }

    public function getAllByUserId(int $user_id): array|false
    {
        $stmt = $this->pdo->prepare("SELECT products.id, products.name, products.description, products.price, products.image, users_products.quantity FROM products JOIN users_products ON products.id = users_products.product_id WHERE user_id =:user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll();
    }

    public function decreaseQuantity(int $user_id, int $product_id, int $quantity): void
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