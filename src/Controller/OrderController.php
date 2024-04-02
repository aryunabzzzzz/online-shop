<?php

namespace Controller;

use Request\OrderRequest;
use Service\Authentication\AuthenticationServiceInterface;
use Service\CartService;
use Service\OrderService;

class OrderController
{
    private OrderService $orderService;
    private CartService $cartService;
    private AuthenticationServiceInterface $authenticationService;

    public function __construct(AuthenticationServiceInterface $authenticationService)
    {
        $this->orderService = new OrderService();
        $this->cartService = new CartService();
        $this->authenticationService = $authenticationService;
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