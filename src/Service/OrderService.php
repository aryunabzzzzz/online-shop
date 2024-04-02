<?php

namespace Service;

use Repository\OrderRepository;
use Repository\OrderProductRepository;
use Repository\UserProductRepository;
use Repository\Repository;

class OrderService
{
    private OrderRepository $orderRepository;
    private OrderProductRepository $orderProductRepository;
    private UserProductRepository $userProductRepository;

    public function __construct(OrderRepository $orderRepository, OrderProductRepository $orderProductRepository, UserProductRepository $userProductRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->orderProductRepository = $orderProductRepository;
        $this->userProductRepository = $userProductRepository;
    }

    public function create(int $userId, string $fullName, string $phone, string $address): void
    {
        $pdo = Repository::getPdo();
        $pdo->beginTransaction();

        try {

            $this->orderRepository->create($userId, $fullName, $phone, $address);
            $orderId = $this->orderRepository->getOrderId();
            $cartProducts = $this->userProductRepository->getAllByUserId($userId);

            foreach ($cartProducts as $cartProduct) {
                $this->orderProductRepository->create($orderId, $cartProduct->getProductEntity()->getId(), $cartProduct->getQuantity(), $cartProduct->getProductEntity()->getPrice());
            }

            $this->userProductRepository->deleteAllByUserId($userId);

            $pdo->commit();

        } catch (\Throwable $exception){
            $pdo->rollBack();
        }
    }
}