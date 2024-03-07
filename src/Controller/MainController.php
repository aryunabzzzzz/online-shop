<?php

class MainController
{
    private Product $productModel;
    public function __construct()
    {
        require_once './../Model/Product.php';
        $this->productModel = new Product();
    }
    public function getMain()
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header("Location: /login");
        }
        $products = $this->productModel->getAll();

        if (empty($products)){
            header("Location: /404.html");
        }

        require_once ('./../View/main.php');
    }

}