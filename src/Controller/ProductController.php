<?php

class ProductController
{
    private Product $productModel;
    private UserProduct $userProductModel;
    public function __construct()
    {
        require_once './../Model/Product.php';
        require_once './../Model/UserProduct.php';
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
    }
    public function postAddProduct()
    {
        session_start();
        $userId = $_SESSION['user_id'];
        $productId = $_POST['id'];
        $quantity = 1;

        if($this->userProductModel->getOneByUserIdProductId($userId,$productId)){
            $this->userProductModel->updateQuantity($userId, $productId, $quantity);
        } else {
            $this->userProductModel->create($userId, $productId, $quantity);
        }

        echo "Товар $productId добавлен в количестве $quantity";

        $products = $this->productModel->getAll();
        require_once ('./../View/main.php');
    }
}