<?php

namespace Controller;

use Repository\UserProductRepository;
use Request\OrderRequest;
use Service\OrderService;

class OrderController
{
    private UserProductRepository $userProductRepository;
    private OrderService $orderService;

    public function __construct()
    {
        $this->userProductRepository = new UserProductRepository();
        $this->orderService = new OrderService();
    }

    public function getOrder(): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header("Location: /login");
        }

        $userId = $_SESSION['user_id'];
        $cartProducts = $this->userProductRepository->getAllByUserId($userId);
        $totalPrice = $this->getTotalPrice($cartProducts);

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
        session_start();
        if(!isset($_SESSION['user_id'])){
            header("Location: /login");
        }

        $errors = $request->validate();

        $userId = $_SESSION['user_id'];
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