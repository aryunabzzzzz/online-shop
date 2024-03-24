<?php

namespace Controller;

use Repository\UserProductRepository;
use Request\OrderRequest;
use Service\OrderService;
use Service\CartService;
use Service\AuthenticationService;

class OrderController
{
    private UserProductRepository $userProductRepository;
    private OrderService $orderService;
    private CartService $cartService;
    private AuthenticationService $authenticationService;

    public function __construct()
    {
        $this->userProductRepository = new UserProductRepository();
        $this->orderService = new OrderService();
        $this->cartService = new CartService();
        $this->authenticationService = new AuthenticationService();
    }

    public function getOrder(): void
    {
        if(!$this->authenticationService->check()){
            header("Location: /login");
        }

        $userId = $this->authenticationService->getCurrentUser()->getId();

        $cartProducts = $this->userProductRepository->getAllByUserId($userId);
        $totalPrice = $this->cartService->getTotalPrice($userId);

        if (!$cartProducts){
            $notification = "Корзина пуста";
        }

        require_once ('./../View/order.php');
    }

    public function getTotalPrice(array $cartProducts): float
    {
        $totalPrice = 0;
        foreach ($cartProducts as $cartProduct) {
            $totalPrice += ($cartProduct->getProductEntity()->getPrice() * $cartProduct->getQuantity());
        }
        return $totalPrice;
    }

    public function postOrder(OrderRequest $request): void
    {
        if(!$this->authenticationService->check()){
            header("Location: /login");
        }

        $userId = $this->authenticationService->getCurrentUser()->getId();

        $errors = $request->validate();

        $cartProducts = $this->userProductRepository->getAllByUserId($userId);
        $totalPrice = $this->getTotalPrice($cartProducts);

        if (!$cartProducts){
            $errors['cart'] = "Корзина пуста";
        }

        if (empty($errors)){
            $this->orderService->create($userId, $request->getFullName(), $request->getPhone(), $request->getAddress());

            header("Location: /main");
        }

        require_once ('./../View/order.php');

    }
}