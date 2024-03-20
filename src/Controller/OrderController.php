<?php

namespace Controller;

use Repository\UserProductRepository;
use Repository\OrderRepository;
use Repository\OrderProductRepository;
use Request\OrderRequest;

class OrderController
{
    private UserProductRepository $userProductRepository;
    private OrderRepository $orderRepository;
    private OrderProductRepository $orderProductRepository;

    public function __construct()
    {
        $this->userProductRepository = new UserProductRepository();
        $this->orderRepository = new OrderRepository();
        $this->orderProductRepository = new OrderProductRepository();
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
            $fullName = $request->getFullName();
            $phone = $request->getPhone();
            $address = $request->getAddress();

            $this->orderRepository->create($userId, $fullName, $phone, $address);
            $orderId = $this->orderRepository->getOrderId();

            foreach ($cartProducts as $cartProduct) {
                $this->orderProductRepository->create($orderId, $cartProduct->getProductEntity()->getId(), $cartProduct->getQuantity(), $cartProduct->getProductEntity()->getPrice());
            }

            $this->userProductRepository->deleteAllByUserId($userId);

            header("Location: /main");
        }

        require_once ('./../View/order.php');

    }
}