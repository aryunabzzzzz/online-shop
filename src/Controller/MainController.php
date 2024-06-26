<?php

namespace Controller;

use Repository\ProductRepository;
use Service\Authentication\AuthenticationServiceInterface;

class MainController
{
    private ProductRepository $productRepository;
    private AuthenticationServiceInterface $authenticationService;

    public function __construct(AuthenticationServiceInterface $authenticationService, ProductRepository $productRepository)
    {
        $this->authenticationService = $authenticationService;
        $this->productRepository = $productRepository;
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