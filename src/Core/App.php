<?php

class App
{
    private array $routes = [
        '/registration'=>[
            'GET'=>[
                'class'=>'UserController',
                'method'=>'getRegistration'
            ],
            'POST'=>[
                'class'=>'UserController',
                'method'=>'postRegistration'
            ],
        ],
        '/login'=>[
            'GET'=>[
                'class'=>'UserController',
                'method'=>'getLogin'
            ],
            'POST'=>[
                'class'=>'UserController',
                'method'=>'postLogin'
            ],
        ],
        '/main'=>[
            'GET'=>[
                'class'=>'MainController',
                'method'=>'getMain'
            ],
        ],
        '/add_product'=>[
            'POST'=>[
                'class'=>'ProductController',
                'method'=>'postAddProduct'
            ],
        ],
        '/delete_product'=>[
            'POST'=>[
                'class'=>'ProductController',
                'method'=>'postDeleteProduct'
            ],
        ],
        '/cart'=>[
            'GET'=>[
                'class'=>'CartController',
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