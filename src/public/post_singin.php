<?php

$errors = [];

if (isset($_POST['email'])){
    $email = $_POST['email'];
    if (empty($email)){
        $errors['email'] = 'Поле не должно быть пустым';
    } elseif(stristr($email, '@') === FALSE) {
        $errors['email'] = 'Некорректно введён email';
    }
} else {
    $errors['email'] = 'Поле не должно быть пустым';
}

if (isset($_POST['psw'])){
    $password = $_POST['psw'];
    if (empty($password)){
        $errors['psw'] = 'Поле не должно быть пустым';
    } elseif (strlen($password)<3){
        $errors['psw'] = 'Слишком короткий пароль';
    }
} else {
    $errors['psw'] = 'Поле не должно быть пустым';
}


if (empty($errors)){
    //соединение с БД
    $pdo = new PDO("pgsql:host=db; port=5432; dbname=laravel","root", "root");
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email'=>$email]);
    $user = $stmt->fetch();
    //проверка наличия пользователя
    if (!$user){
        $errors['email'] = 'Пользователя с таким адресом почты не существует';
    } else {
        //проверка пароля
        if (password_verify($password, $user['password'])){
            echo "EEEE";
        } else {
            $errors['email'] = 'Неправильный адрес почты или пароль';
        }
    }
}

require_once ('./singin.php');