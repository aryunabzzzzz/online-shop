<?php

namespace Controller;

use Repository\ProductRepository;
use Service\AuthenticationService;

class MainController
{
    private ProductRepository $productRepository;
    private AuthenticationService $authenticationService;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
        $this->authenticationService = new AuthenticationService();
    }

    public function getMain(): void
    {
        if(!$this->authenticationService->check()){
            header("Location: /login");
        }

        $products = $this->productRepository->getAll();

        if (empty($products)){
            header("Location: /404.html");
        }

        require_once ('./../View/main.php');
    }

}