<?php
//session_start();
//if(!isset($_SESSION['user_id'])){
//    header("Location: /login");
//}
function validationAddProduct(array $arr):array
{
    $errors = [];

    if (empty($arr['product_id'])) {
        $errors['product_id'] = 'Поле не должно быть пустым';
    } else {
        $product_id = $arr['product_id'];

        $pdo = new PDO("pgsql:host=db; port=5432; dbname=laravel","root", "root");
        $stmt = $pdo->query("SELECT * FROM products");
        $id = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (!in_array($product_id,$id)){
            $errors['product_id'] = "Продукта с таким id не существует";
        }
    }

    if (empty($arr['quantity'])) {
        $errors['quantity'] = 'Поле не должно быть пустым';
    } else {
        $quantity = $arr['quantity'];
        if ($quantity<=0){
            $errors['quantity'] = 'Количество товара должно быть больше 0';
        }
    }

    return $errors;
}

$errors = validationAddProduct($_POST);
require_once ('./add_product.php');

if (empty($errors)){
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    //создание объекта класса
    $pdo = new PDO("pgsql:host=db; port=5432; dbname=laravel","root", "root");
    //добавление данных пользователя в БД + защита от SQL-инъекции
    $stmt = $pdo->prepare("INSERT INTO users_products (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
    $stmt->execute(['user_id'=>$user_id, 'product_id'=>$product_id, 'quantity'=>$quantity]);
    //возврат данных пользователя на экран
    $stmt = $pdo->prepare("SELECT * FROM users_products WHERE user_id = :user_id");
    $stmt->execute(['user_id'=>$user_id]);
    $product = $stmt->fetch();

    print_r($product);
}

