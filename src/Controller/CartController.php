<?php

namespace Controller;

use Repository\UserProductRepository;
use Request\CartRequest;
use Service\CartService;

class CartController
{
    private UserProductRepository $userProductRepository;
    private CartService $cartService;

    public function __construct()
    {
        $this->userProductRepository = new UserProductRepository();
        $this->cartService = new  CartService();
    }

    public function getCart(): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header("Location: /login");
        }

        $userId = $_SESSION['user_id'];
        $cartProducts = $this->userProductRepository->getAllByUserId($userId);
        $totalPrice = $this->cartService->getTotalPrice($userId);

        if (!$cartProducts){
            $notification = "Корзина пуста";
        }

        require_once ('./../View/cart.php');
    }

    public function postAddProduct(CartRequest $request): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header("Location: /login");
        }

        $userId = $_SESSION['user_id'];
        $productId = $request->getProductId();

        $this->cartService->addProduct($userId, $productId);

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

        $this->cartService->deleteProduct($userId, $productId);

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

        $this->cartService->addProduct($userId, $productId);

        header("Location: /cart");

    }

}