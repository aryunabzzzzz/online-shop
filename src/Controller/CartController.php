<?php

class CartController
{
    private Product $productModel;
    private UserProduct $userProductModel;
    public function __construct()
    {
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
    }
    public function getCart(): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header("Location: /login");
        }
        $products = $this->productModel->getAll();

        require_once ('./../View/cart.php');
    }

    public function Cart()
    {

    }

}