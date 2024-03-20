<?php

namespace Core;

use Controller\CartController;
use Controller\MainController;
use Controller\UserController;
use Controller\OrderController;
use Request\CartRequest;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\RegistrationRequest;
use Request\Request;

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
                'method'=>'postRegistration',
                'request'=>RegistrationRequest::class
            ],
        ],
        '/login'=>[
            'GET'=>[
                'class'=>UserController::class,
                'method'=>'getLogin'
            ],
            'POST'=>[
                'class'=>UserController::class,
                'method'=>'postLogin',
                'request'=>LoginRequest::class
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
                'method'=>'postAddProduct',
                'request'=>CartRequest::class
            ],
        ],
        '/delete_product'=>[
            'POST'=>[
                'class'=>CartController::class,
                'method'=>'postDeleteProduct',
                'request'=>CartRequest::class
            ],
        ],
        '/plus_product'=>[
            'POST'=>[
                'class'=>CartController::class,
                'method'=>'plusProduct',
                'request'=>CartRequest::class
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
                'method'=>'postOrder',
                'request'=>OrderRequest::class
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
                $requestClass = Request::class;

                if (isset($handler['request'])){
                    $requestClass = $handler['request'];
                }

                $request = new $requestClass($method, $requestUri, headers_list(), $_POST);

                $obj = new $className;
                $obj->$method($request);

            } else {
                echo "$requestMethod не поддерживается $requestUri";
            }
        } else {
            require_once './../View/404.html';
        }
    }

}