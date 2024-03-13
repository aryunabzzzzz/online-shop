<?php

namespace Model;

class Customer extends Model
{
    public function create(int $user_id, string $full_name, int $phone, string $address): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO customers (user_id, full_name, phone, address) VALUES (:user_id, :full_name, :phone, :address)");
        $stmt->execute(['user_id'=>$user_id, 'full_name'=>$full_name, 'phone'=>$phone, 'address'=>$address]);
    }
}