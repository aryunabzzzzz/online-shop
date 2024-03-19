<?php

namespace Controller;

use Repository\ProductRepository;

class MainController
{
    private ProductRepository $productRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
    }

    public function getMain(): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])){
            header("Location: /login");
        }
        $products = $this->productRepository->getAll();

        if (empty($products)){
            header("Location: /404.html");
        }

        require_once ('./../View/main.php');
    }

}