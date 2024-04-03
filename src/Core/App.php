<?php

namespace Core;

use Psr\Log\LoggerInterface;
use Request\Request;

class App
{
    private array $routes = [];
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function run(): void
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        try{
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

                    $obj = $this->container->get($className);
                    $obj->$method($request);

                } else {
                    echo "$requestMethod не поддерживается $requestUri";
                }
            } else {
                require_once './../View/404.html';
            }
        } catch (\Throwable $exception){
            $logger = $this->container->get(LoggerInterface::class);

            $data = [
                'message' => 'Сообщение об ошибке: ' . $exception->getMessage(),
                'code' => 'Код: ' . $exception->getCode(),
                'file' => 'Файл: ' . $exception->getFile(),
                'line' => 'Строка: ' . $exception->getLine(),
                'stackTrace' => 'Стэк: ' . $exception->getTraceAsString(),
                'details' => 'Подробная информация: ' . $exception->__toString()
            ];

            $logger->error("code execution error\n", $data);

            require_once './../View/500.html';
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