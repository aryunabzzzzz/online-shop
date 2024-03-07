<?php

class App
{
    public function run()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        if ($uri === '/registration'){
            $obj = new UserController();
            if ($method === 'GET'){
                $obj->getRegistration();
            } elseif ($method === 'POST'){
                $obj->postRegistration();
            } else {
                echo "$method не поддерживается $uri";
            }
        } elseif ($uri === '/login'){
            $obj = new UserController();
            if ($method === 'GET'){
                $obj->getLogin();
            } elseif ($method === 'POST'){
                $obj->postLogin();
            } else {
                echo "$method не поддерживается $uri";
            }
        } elseif ($uri === '/main'){
            $obj = new MainController();
            if($method === 'GET'){
                $obj->getMain();
            } else {
                echo "$method не поддерживается $uri";
            }
        } elseif ($uri === '/add_product'){
            $obj = new ProductController();
            if ($method === 'POST'){
                $obj->postAddProduct();
            } else {
                echo "$method не поддерживается $uri";
            }
        } elseif ($uri === '/cart'){
            $obj = new CartController();
            if ($method === 'GET'){
                $obj->getCart();
            } else {
                echo "$method не поддерживается $uri";
            }
        } else {
            require_once './../View/404.html';
        }
    }

}