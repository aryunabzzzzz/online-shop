<?php

namespace Service;

use Repository\UserProductRepository;

class CartService
{
    private UserProductRepository $userProductRepository;

    public function __construct()
    {
        $this->userProductRepository = new UserProductRepository();
    }

    public function addProduct(int $userId, int $productId): void
    {
        if($this->userProductRepository->getOneByUserIdProductId($userId,$productId)){
            $this->userProductRepository->increaseQuantity($userId, $productId);
        } else {
            $this->userProductRepository->create($userId, $productId);
        }
    }

    public function deleteProduct(int $userId, int $productId): void
    {
        $quantity = $this->userProductRepository->getOneByUserIdProductId($userId,$productId)->getQuantity();

        if($quantity > 1){
            $this->userProductRepository->decreaseQuantity($userId, $productId);
        } else {
            $this->userProductRepository->delete($userId, $productId);
        }
    }

    public function getTotalPrice(int $userId): float
    {
        $cartProducts = $this->userProductRepository->getAllByUserId($userId);

        $totalPrice = 0;
        foreach ($cartProducts as $cartProduct) {
            $totalPrice += ($cartProduct->getProductEntity()->getPrice() * $cartProduct->getQuantity());
        }
        return $totalPrice;
    }

}