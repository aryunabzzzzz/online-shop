<?php

namespace Controller;

use Repository\UserProductRepository;
use Repository\OrderRepository;
use Repository\OrderProductRepository;

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
            $totalPrice += ($cartProduct->getProductEntity()->getPrice()* $cartProduct->getQuantity());
        }
        return $totalPrice;
    }

    public function postOrder(array $data): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header("Location: /login");
        }

        $errors = $this->validateOrder($data);

        $userId = $_SESSION['user_id'];
        $cartProducts = $this->userProductRepository->getAllByUserId($userId);
        $totalPrice = $this->getTotalPrice($cartProducts);

        if (!$cartProducts){
            $errors['cart'] = "Корзина пуста";
        }

        if (empty($errors)){
            $fullName = $data['fullName'];
            $phone = $data['phone'];
            $address = $data['address'];

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

    public function validateOrder(array $data): array
    {
        $errors = [];

        if (empty($data['fullName'])){
            $errors['fullName'] = 'Поле не должно быть пустым';
        } else {
            $fullName = $data['fullName'];
            if (!preg_match("/^[a-zA-Z-' ]*$/",$fullName)) {
                $errors['fullName'] = "Поле должно содержать только буквы и пробелы";
            }
        }

        if (empty($data['phone'])){
            $errors['phone'] = 'Поле не должно быть пустым';
        } else {
            $phone = $data['phone'];
            if (!preg_match("/^(\+7|7|8)?[\s\-]?\(?[489][0-9]{2}\)?[\s\-]?[0-9]{3}[\s\-]?[0-9]{2}[\s\-]?[0-9]{2}$/",$phone)) {
                $errors['phone'] = "Неккоректный номер телефона";
            }
        }

        if (empty($data['address'])){
            $errors['address'] = 'Поле не должно быть пустым';
        } else {
            $address = $data['address'];
            if (!preg_match("/^[a-zA-Z-' ]*$/",$address)) {
                $errors['address'] = "Поле должно содержать только буквы и пробелы";
            }
        }

        return $errors;
    }

}