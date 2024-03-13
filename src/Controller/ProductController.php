<?php

namespace Controller;

use Model\Product;
use Model\UserProduct;

class ProductController
{
    private Product $productModel;
    private UserProduct $userProductModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
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
            $this->userProductModel->increaseQuantity($userId, $productId, $quantity);
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

        $product = $this->userProductModel->getQuantityByUserIdProductId($userId, $productId);
        $quantity = $product ['quantity'];

        if($quantity > 1){
            $this->userProductModel->decreaseQuantity($userId, $productId, $quantity);
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

        $product = $this->userProductModel->getQuantityByUserIdProductId($userId, $productId);
        $quantity = 1;

        if($quantity < 100){
            $this->userProductModel->increaseQuantity($userId, $productId, $quantity);
        } else {
            $message = 'ddddddddd';
        }

        header("Location: /cart");

    }
}