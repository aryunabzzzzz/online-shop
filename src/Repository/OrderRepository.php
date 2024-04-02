<?php

namespace Repository;

class OrderRepository extends Repository
{
    public function create(int $user_id, string $full_name, int $phone, string $address): void
    {
        $stmt = self::getPdo()->prepare("INSERT INTO orders (user_id, full_name, phone, address) VALUES (:user_id, :full_name, :phone, :address)");
        $stmt->execute(['user_id'=>$user_id, 'full_name'=>$full_name, 'phone'=>$phone, 'address'=>$address]);
    }

    public function getOrderId(): string
    {
        return self::getPdo()->lastInsertId();
    }
}