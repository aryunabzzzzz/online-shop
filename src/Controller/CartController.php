<?php

namespace Controller;

use Model\UserProduct;
class CartController
{
    private UserProduct $userProductModel;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
    }

    public function getCart(): void
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

        require_once ('./../View/cart.php');
    }

    public function getTotalPrice(array $cartProducts): float
    {
        $totalPrice = 0;
        foreach ($cartProducts as $cartProduct) {
            $totalPrice += ($cartProduct->getProductEntity()->getPrice() * $cartProduct->getQuantity());
        }
        return $totalPrice;
    }

    public function postAddProduct(array $data): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header("Location: /login");
        }

        $userId = $_SESSION['user_id'];
        $productId = $data['id'];
        $quantity = 1;

        if($this->userProductModel->getOneByUserIdProductId($userId,$productId)){
            $this->userProductModel->increaseQuantity($userId, $productId);
        } else {
            $this->userProductModel->create($userId, $productId, $quantity);
        }

        header("Location: /main");

    }

    public function postDeleteProduct(array $data): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header("Location: /login");
        }
        $userId = $_SESSION['user_id'];
        $productId = $data['id'];

        $quantity = $this->userProductModel->getOneByUserIdProductId($userId,$productId)->getQuantity();

        if($quantity > 1){
            $this->userProductModel->decreaseQuantity($userId, $productId);
        } else {
            $this->userProductModel->delete($userId, $productId);
        }

        header("Location: /cart");

    }

    public function plusProduct(array $data): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header("Location: /login");
        }
        $userId = $_SESSION['user_id'];
        $productId = $data['id'];

        $this->userProductModel->increaseQuantity($userId, $productId);

        header("Location: /cart");

    }

}