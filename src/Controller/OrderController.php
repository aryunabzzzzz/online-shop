<?php

namespace Controller;

use Request\OrderRequest;
use Service\OrderService;
use Service\CartService;
use Service\AuthenticationService;

class OrderController
{
    private OrderService $orderService;
    private CartService $cartService;
    private AuthenticationService $authenticationService;

    public function __construct()
    {
        $this->orderService = new OrderService();
        $this->cartService = new CartService();
        $this->authenticationService = new AuthenticationService();
    }

    public function getOrder(): void
    {
        if(!$this->authenticationService->check()){
            header("Location: /login");
        }

        $cartProducts = $this->cartService->getProducts();
        $totalPrice = $this->cartService->getTotalPrice();

        if (!$cartProducts){
            $notification = "Корзина пуста";
        }

        require_once ('./../View/order.php');
    }

    public function postOrder(OrderRequest $request): void
    {
        if(!$this->authenticationService->check()){
            header("Location: /login");
        }

        $errors = $request->validate();

        $cartProducts = $this->cartService->getProducts();
        $totalPrice = $this->cartService->getTotalPrice();

        if (!$cartProducts){
            $errors['cart'] = "Корзина пуста";
        }

        if (empty($errors)){
            $user = $this->authenticationService->getCurrentUser();
            $this->orderService->create($user->getId(), $request->getFullName(), $request->getPhone(), $request->getAddress());

            header("Location: /main");
        }

        require_once ('./../View/order.php');

    }
}