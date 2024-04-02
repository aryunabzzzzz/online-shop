<?php


use Controller\CartController;
use Controller\MainController;
use Controller\OrderController;
use Controller\UserController;
use Core\Container;
use Repository\OrderProductRepository;
use Repository\OrderRepository;
use Repository\ProductRepository;
use Repository\UserProductRepository;
use Repository\UserRepository;
use Service\Authentication\AuthenticationServiceInterface;
use Service\Authentication\SessionAuthenticationService;
use Service\CartService;
use Service\OrderService;

return [
    CartController::class => function (Container $container) {
      $authService = $container->get(AuthenticationServiceInterface::class);
      $cartService = $container->get(CartService::class);

      return new CartController($authService, $cartService);
    },
    MainController::class => function (Container $container){
      $authService = $container->get(AuthenticationServiceInterface::class);
      $productRepository = new ProductRepository();

      return new MainController($authService, $productRepository);
    },
    OrderController::class => function (Container $container){
        $authService = $container->get(AuthenticationServiceInterface::class);
        $orderService = $container->get(OrderService::class);
        $cartService = $container->get(CartService::class);

        return new OrderController($authService, $orderService, $cartService);
    },
    UserController::class => function (Container $container){
        $authService = $container->get(AuthenticationServiceInterface::class);
        $userRepository = new UserRepository();

        return new UserController($authService, $userRepository);
    },
    CartService::class => function (Container $container){
        $authService = $container->get(AuthenticationServiceInterface::class);
        $userProductRepository = new UserProductRepository();

        return new CartService($authService, $userProductRepository);
    },
    OrderService::class => function (){
        $orderRepository = new OrderRepository();
        $orderProductRepository = new OrderProductRepository();
        $userProductRepository = new UserProductRepository();

        return new OrderService($orderRepository, $orderProductRepository, $userProductRepository);
    },
    AuthenticationServiceInterface::class => function (){
        return new SessionAuthenticationService();
    }
];