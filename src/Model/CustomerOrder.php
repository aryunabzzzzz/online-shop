<?php

namespace Model;

class CustomerOrder extends Model
{
    public function create(int $customer_id, int $order_id)
    {
        $stmt = $this->pdo->prepare("INSERT INTO products_order (customer_id,order_id) VALUES (:customer_id, :order_id)");
        $stmt->execute(['customer_id'=>$customer_id, 'order_id'=>$order_id]);
    }

}