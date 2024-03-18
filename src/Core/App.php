<?php

namespace Core;

use Controller\CartController;
use Controller\MainController;
use Controller\UserController;
use Controller\OrderController;

class App
{
    private array $routes = [
        '/registration'=>[
            'GET'=>[
                'class'=>UserController::class,
                'method'=>'getRegistration'
            ],
            'POST'=>[
                'class'=>UserController::class,
                'method'=>'postRegistration'
            ],
        ],
        '/login'=>[
            'GET'=>[
                'class'=>UserController::class,
                'method'=>'getLogin'
            ],
            'POST'=>[
                'class'=>UserController::class,
                'method'=>'postLogin'
            ],
        ],
        '/logout'=>[
            'GET'=>[
                'class'=>UserController::class,
                'method'=>'getLogout'
            ],
        ],
        '/main'=>[
            'GET'=>[
                'class'=>MainController::class,
                'method'=>'getMain'
            ],
        ],
        '/add_product'=>[
            'POST'=>[
                'class'=>CartController::class,
                'method'=>'postAddProduct'
            ],
        ],
        '/delete_product'=>[
            'POST'=>[
                'class'=>CartController::class,
                'method'=>'postDeleteProduct'
            ],
        ],
        '/plus_product'=>[
            'POST'=>[
                'class'=>CartController::class,
                'method'=>'plusProduct'
            ],
        ],
        '/cart'=>[
            'GET'=>[
                'class'=>CartController::class,
                'method'=>'getCart'
            ],
        ],
        '/order'=>[
            'GET'=>[
                'class'=>OrderController::class,
                'method'=>'getOrder'
            ],
            'POST'=>[
                'class'=>OrderController::class,
                'method'=>'postOrder'
            ],
        ],
    ];
    public function run(): void
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$requestUri])){
            $routeMethod = $this->routes[$requestUri];

            if (isset($routeMethod[$requestMethod])){
                $handler = $routeMethod[$requestMethod];
                $className = $handler['class'];
                $method = $handler['method'];
                $obj = new $className;
                $obj->$method($_POST);
            } else {
                echo "$requestMethod не поддерживается $requestUri";
            }
        } else {
            require_once './../View/404.html';
        }
    }

}