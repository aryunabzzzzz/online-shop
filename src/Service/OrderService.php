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
    private Repository $repository;

    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
        $this->orderProductRepository = new OrderProductRepository();
        $this->userProductRepository = new UserProductRepository();
        $this->repository = new Repository();
    }

    public function create(int $userId, string $fullName, string $phone, string $address): void
    {
        $this->repository->beginTransaction();

        try {

            $this->orderRepository->create($userId, $fullName, $phone, $address);
            $orderId = $this->orderRepository->getOrderId();
            $cartProducts = $this->userProductRepository->getAllByUserId($userId);

            foreach ($cartProducts as $cartProduct) {
                $this->orderProductRepository->create($orderId, $cartProduct->getProductEntity()->getId(), $cartProduct->getQuantity(), $cartProduct->getProductEntity()->getPrice());
            }

            $this->userProductRepository->deleteAllByUserId($userId);

            $this->repository->commitTransaction();

        } catch (\Throwable $exception){
            $this->repository->rollbackTransaction();
        }
    }
}