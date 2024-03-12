<?php

namespace Core;

use Controller\CartController;
use Controller\MainController;
use Controller\ProductController;
use Controller\UserController;

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
                'class'=>ProductController::class,
                'method'=>'postAddProduct'
            ],
        ],
        '/delete_product'=>[
            'POST'=>[
                'class'=>ProductController::class,
                'method'=>'postDeleteProduct'
            ],
        ],
        '/cart'=>[
            'GET'=>[
                'class'=>CartController::class,
                'method'=>'getCart'
            ],
        ],
    ];
    public function run(): void
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        $routes = $this->routes;

        if (isset($routes[$uri])){
            $routeMethod = $this->routes[$uri];
            if (isset($routeMethod[$method])){
                $test = $routeMethod[$method];
                $className = $test['class'];
                $function = $test['method'];
                $obj = new $className;
                $obj->$function();
            } else {
                echo "$method не поддерживается $uri";
            }
        } else {
            require_once './../View/404.html';
        }
    }

}