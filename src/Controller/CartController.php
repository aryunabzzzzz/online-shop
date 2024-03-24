<?php

namespace Controller;

use Request\CartRequest;
use Service\CartService;
use Service\AuthenticationService;

class CartController
{
    private CartService $cartService;
    private AuthenticationService $authenticationService;

    public function __construct()
    {
        $this->cartService = new  CartService();
        $this->authenticationService = new AuthenticationService();
    }

    public function getCart(): void
    {
        if(!$this->authenticationService->check()){
            header("Location: /login");
        }

        $userId = $this->authenticationService->getCurrentUser()->getId();

        $cartProducts = $this->cartService->getCartProducts($userId);
        $totalPrice = $this->cartService->getTotalPrice($userId);

        if (!$cartProducts){
            $notification = "Корзина пуста";
        }

        require_once ('./../View/cart.php');
    }

    public function postAddProduct(CartRequest $request): void
    {
        if(!$this->authenticationService->check()){
            header("Location: /login");
        }

        $userId = $this->authenticationService->getCurrentUser()->getId();

        $productId = $request->getProductId();

        $this->cartService->addProduct($userId, $productId);

        header("Location: /main");

    }

    public function postDeleteProduct(CartRequest $request): void
    {
        if(!$this->authenticationService->check()){
            header("Location: /login");
        }

        $userId = $this->authenticationService->getCurrentUser()->getId();

        $productId = $request->getProductId();

        $this->cartService->deleteProduct($userId, $productId);

        header("Location: /cart");

    }

    public function plusProduct(CartRequest $request): void
    {
        if(!$this->authenticationService->check()){
            header("Location: /login");
        }

        $userId = $this->authenticationService->getCurrentUser()->getId();

        $productId = $request->getProductId();

        $this->cartService->addProduct($userId, $productId);

        header("Location: /cart");

    }

}