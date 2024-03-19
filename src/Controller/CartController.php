<?php

namespace Controller;

use Repository\UserProductRepository;
class CartController
{
    private UserProductRepository $userProductRepository;

    public function __construct()
    {
        $this->userProductRepository = new UserProductRepository();
    }

    public function getCart(): void
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

        if($this->userProductRepository->getOneByUserIdProductId($userId,$productId)){
            $this->userProductRepository->increaseQuantity($userId, $productId);
        } else {
            $this->userProductRepository->create($userId, $productId, $quantity);
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

        $quantity = $this->userProductRepository->getOneByUserIdProductId($userId,$productId)->getQuantity();

        if($quantity > 1){
            $this->userProductRepository->decreaseQuantity($userId, $productId);
        } else {
            $this->userProductRepository->delete($userId, $productId);
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

        $this->userProductRepository->increaseQuantity($userId, $productId);

        header("Location: /cart");

    }

}