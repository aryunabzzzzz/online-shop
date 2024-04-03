<?php

namespace Service;

use Repository\UserProductRepository;
use Service\Authentication\AuthenticationServiceInterface;

class CartService
{
    private UserProductRepository $userProductRepository;
    private AuthenticationServiceInterface $authenticationService;

    public function __construct(AuthenticationServiceInterface $authenticationService, UserProductRepository $userProductRepository)
    {
        $this->authenticationService = $authenticationService;
        $this->userProductRepository = $userProductRepository;
    }

    public function addProduct(int $productId): void
    {
        $user = $this->authenticationService->getCurrentUser();
        if(!$user){
            return;
        }

        $userId = $user->getId();

        if($this->userProductRepository->getOneByUserIdProductId($userId,$productId)){
            $this->userProductRepository->increaseQuantity($userId, $productId);
        } else {
            $this->userProductRepository->create($userId, $productId);
        }
    }

    public function deleteProduct(int $productId): void
    {
        $user = $this->authenticationService->getCurrentUser();
        if(!$user){
            return;
        }

        $userId = $user->getId();

        $quantity = $this->userProductRepository->getOneByUserIdProductId($userId,$productId)->getQuantity();

        if($quantity > 1){
            $this->userProductRepository->decreaseQuantity($userId, $productId);
        } else {
            $this->userProductRepository->delete($userId, $productId);
        }
    }

    public function getTotalPrice(): float
    {
        $cartProducts = $this->getProducts();

        if (empty($cartProducts)){
            return 0;
        }

        $totalPrice = 0;
        foreach ($cartProducts as $cartProduct) {
            $totalPrice += ($cartProduct->getProductEntity()->getPrice() * $cartProduct->getQuantity());
        }
        return $totalPrice;
    }

    public function getProducts(): array
    {
        $user = $this->authenticationService->getCurrentUser();
        if(!$user){
            return [];
        }

        return $this->userProductRepository->getAllByUserId($user->getId());
    }

}