<?php

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/registration'){
    if ($method === 'GET'){
        require_once 'registration.php';
    } elseif ($method === 'POST'){
        require_once 'post_registration.php';
    } else {
        echo "$method не поддерживается $uri";
    }
} elseif ($uri === '/login'){
    if ($method === 'GET'){
        require_once 'login.php';
    } elseif ($method === 'POST'){
        require_once 'post_login.php';
    } else {
        echo "$method не поддерживается $uri";
    }
} elseif ($uri === '/main'){
    if($method === 'GET'){
        require_once 'main.php';
    } else {
        echo "$method не поддерживается $uri";
    }
} else {
    require_once '404.html';
}