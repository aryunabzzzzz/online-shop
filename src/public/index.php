<?php

use Controller\CartController;
use Controller\MainController;
use Controller\OrderController;
use Controller\UserController;
Use Core\Autoloader;
Use Core\App;
use Request\CartRequest;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\RegistrationRequest;

require_once "./../Core/App.php";
require_once "./../Core/Autoloader.php";

Autoloader::registrate(dirname(__DIR__));

$app = new App();

$app->get('/registration', UserController::class, 'getRegistration');
$app->post('/registration', UserController::class, 'postRegistration', RegistrationRequest::class);
$app->get('/login', UserController::class, 'getLogin');
$app->post('/login', UserController::class, 'postLogin', LoginRequest::class);
$app->get('/logout', UserController::class, 'getLogout');
$app->get('/main', MainController::class, 'getMain');
$app->post('/add_product', CartController::class, 'postAddProduct', CartRequest::class);
$app->post('/delete_product', CartController::class, 'postDeleteProduct', CartRequest::class);
$app->post('/plus_product', CartController::class, 'plusProduct', CartRequest::class);
$app->get('/cart', CartController::class, 'getCart');
$app->get('/order', OrderController::class, 'getOrder');
$app->post('/order', OrderController::class, 'postOrder', OrderRequest::class);


$app->run();