<?php

namespace Controller;

use Request\CartRequest;
use Service\Authentication\AuthenticationServiceInterface;
use Service\CartService;

class CartController
{
    private CartService $cartService;
    private AuthenticationServiceInterface $authenticationService;

    public function __construct(AuthenticationServiceInterface $authenticationService)
    {
        $this->cartService = new  CartService();
        $this->authenticationService = $authenticationService;
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