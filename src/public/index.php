<?php

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/registration'){
    require_once './../Controller/UserController.php';
    $obj = new UserController();
    if ($method === 'GET'){
        $obj->getRegistration();
    } elseif ($method === 'POST'){
        $obj->postRegistration();
    } else {
        echo "$method не поддерживается $uri";
    }
} elseif ($uri === '/login'){
    require_once './../Controller/UserController.php';
    $obj = new UserController();
    if ($method === 'GET'){
        $obj->getLogin();
    } elseif ($method === 'POST'){
        $obj->postLogin();
    } else {
        echo "$method не поддерживается $uri";
    }
} elseif ($uri === '/main'){
    require_once './../Controller/MainController.php';
    $obj = new MainController();
    if($method === 'GET'){
        $obj->main();
    } elseif ($method === 'POST'){
        $obj->postMain();
    } else {
        echo "$method не поддерживается $uri";
    }
} elseif ($uri === '/add_product'){
    require_once './../Controller/ProductController.php';
    $obj = new ProductController();
    if ($method === 'GET'){
        $obj->addProduct();
    } elseif ($method === 'POST'){
        $obj->postAddProduct();
    } else {
        echo "$method не поддерживается $uri";
    }
}else {
    require_once '404.html';
}