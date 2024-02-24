<?php
//процедура валидации

$errors = [];

if (isset($_POST['name'])){
    $name = $_POST['name'];
    if (empty($name)){
        $errors['name'] = 'Поле не должно быть пустым';
    } elseif (strlen($name)<3){
        $errors['name'] = 'Слишком короткое имя пользователя';
    }
} else {
    $errors['name'] = 'Поле не должно быть пустым';
}

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

if (isset($_POST['psw-repeat'])){
    $passwordRepeat = $_POST['psw-repeat'];
    if (empty($passwordRepeat)){
        $errors['psw-repeat'] = 'Поле не должно быть пустым';
    }
    if ($passwordRepeat != $password){
        $errors['psw-repeat'] = 'Пароли не совпадают!';
    }
} else {
    $errors['psw-repeat'] = 'Поле не должно быть пустым';
}


if (empty($errors)){
    //создание объекта класса
    $pdo = new PDO("pgsql:host=db; port=5432; dbname=laravel","root", "root");
    //защита пароля
    $password = password_hash($password, PASSWORD_DEFAULT);
    //добавление данных пользователя в БД + защита от SQL-инъекции
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->execute(['name'=>$name, 'email'=>$email, 'password'=>$password]);
    //возврат данных пользователя на экран
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email'=>$email]);
    $result = $stmt->fetch();
    print_r($result);

}

require_once ('./registration.php');