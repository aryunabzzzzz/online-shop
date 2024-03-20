<?php

namespace Controller;

use Repository\UserProductRepository;
use Request\CartRequest;

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

    public function postAddProduct(CartRequest $request): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header("Location: /login");
        }

        $userId = $_SESSION['user_id'];
        $productId = $request->getProductId();

        if($this->userProductRepository->getOneByUserIdProductId($userId,$productId)){
            $this->userProductRepository->increaseQuantity($userId, $productId);
        } else {
            $this->userProductRepository->create($userId, $productId);
        }

        header("Location: /main");

    }

    public function postDeleteProduct(CartRequest $request): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header("Location: /login");
        }
        $userId = $_SESSION['user_id'];
        $productId = $request->getProductId();

        $quantity = $this->userProductRepository->getOneByUserIdProductId($userId,$productId)->getQuantity();

        if($quantity > 1){
            $this->userProductRepository->decreaseQuantity($userId, $productId);
        } else {
            $this->userProductRepository->delete($userId, $productId);
        }

        header("Location: /cart");

    }

    public function plusProduct(CartRequest $request): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header("Location: /login");
        }
        $userId = $_SESSION['user_id'];
        $productId = $request->getProductId();

        $this->userProductRepository->increaseQuantity($userId, $productId);

        header("Location: /cart");

    }

}