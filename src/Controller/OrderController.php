<?php

namespace Controller;

use Model\UserProduct;
use Model\Customer;
use Model\ProductOrder;
use Model\CustomerOrder;

class OrderController
{
    private UserProduct $userProductModel;
    private Customer $customerModel;
    private ProductOrder $productOrderModel;
    private CustomerOrder $customerOrderModel;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->customerModel = new Customer();
        $this->productOrderModel = new ProductOrder();
        $this->customerOrderModel = new CustomerOrder();
    }

    public function getOrder(): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header("Location: /login");
        }

        $userId = $_SESSION['user_id'];
        $cartProducts = $this->userProductModel->getAllByUserId($userId);
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
            $totalPrice += ($cartProduct['price'] * $cartProduct['quantity']);
        }
        return $totalPrice;
    }

    public function postOrder(array $data): void
    {
        $errors = $this->validateOrder($data);

        session_start();
        if(!isset($_SESSION['user_id'])){
            header("Location: /login");
        }

        $userId = $_SESSION['user_id'];
        $cartProducts = $this->userProductModel->getAllByUserId($userId);
        $totalPrice = $this->getTotalPrice($cartProducts);

        if (empty($errors)){
            $fullName = $data['fullName'];
            $phone = $data['phone'];
            $address = $data['address'];

            $this->customerModel->create($userId, $fullName, $phone, $address);

            foreach ($cartProducts as $cartProduct) {
                $this->productOrderModel->create($cartProduct['id'], $cartProduct['name'], $cartProduct['quantity'], $cartProduct['price']);
            }

            $this->userProductModel->deleteAllByUserId($userId);

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