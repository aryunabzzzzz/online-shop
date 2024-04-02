<?php

namespace Core;

use Request\Request;
use Service\Authentication\SessionAuthenticationService;

class App
{
    private array $routes = [];

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

                $authService = new SessionAuthenticationService();

                $obj = new $className($authService);
                $obj->$method($request);

            } else {
                echo "$requestMethod не поддерживается $requestUri";
            }
        } else {
            require_once './../View/404.html';
        }
    }

    public function get(string $routeName, string $className, string $method, string $request = null): void
    {
        $this->routes[$routeName]['GET'] = [
            'class'=>$className,
            'method'=>$method,
            'request'=>$request
        ];
    }

    public function post(string $routeName, string $className, string $method, string $request = null): void
    {
        $this->routes[$routeName]['POST'] = [
            'class'=>$className,
            'method'=>$method,
            'request'=>$request
        ];
    }

}