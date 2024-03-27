<?php

namespace Controller;

use Repository\ProductRepository;
use Service\Authentication\SessionAuthenticationService;

class MainController
{
    private ProductRepository $productRepository;
    private SessionAuthenticationService $authenticationService;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
        $this->authenticationService = new SessionAuthenticationService();
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