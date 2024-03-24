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

        $cartProducts = $this->cartService->getProducts();
        $totalPrice = $this->cartService->getTotalPrice();

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

        $productId = $request->getProductId();
        $this->cartService->addProduct($productId);

        header("Location: /main");

    }

    public function postDeleteProduct(CartRequest $request): void
    {
        if(!$this->authenticationService->check()){
            header("Location: /login");
        }

        $productId = $request->getProductId();
        $this->cartService->deleteProduct($productId);

        header("Location: /cart");

    }

    public function plusProduct(CartRequest $request): void
    {
        if(!$this->authenticationService->check()){
            header("Location: /login");
        }

        $productId = $request->getProductId();
        $this->cartService->addProduct($productId);

        header("Location: /cart");

    }

}