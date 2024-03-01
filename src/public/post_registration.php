<?php
//процедура валидации
function validation(array $arr):array
{
    $errors = [];

    if (isset($arr['name'])){
        $name = $arr['name'];
        if (empty($name)){
            $errors['name'] = 'Поле не должно быть пустым';
        } elseif (strlen($name)<3){
            $errors['name'] = 'Слишком короткое имя пользователя';
        }
    } else {
        $errors['name'] = 'Поле не должно быть пустым';
    }

    if (isset($arr['email'])){
        $email = $arr['email'];
        if (empty($email)){
            $errors['email'] = 'Поле не должно быть пустым';
        } elseif(stristr($email, '@') === FALSE) {
            $errors['email'] = 'Некорректно введён email';
        }
    } else {
        $errors['email'] = 'Поле не должно быть пустым';
    }

    if (isset($arr['psw'])){
        $password = $arr['psw'];
        if (empty($password)){
            $errors['psw'] = 'Поле не должно быть пустым';
        } elseif (strlen($password)<3){
            $errors['psw'] = 'Слишком короткий пароль';
        }
    } else {
        $errors['psw'] = 'Поле не должно быть пустым';
    }

    if (isset($arr['psw-repeat'])){
        $passwordRepeat = $arr['psw-repeat'];
        if (empty($passwordRepeat)){
            $errors['psw-repeat'] = 'Поле не должно быть пустым';
        }
        if ($passwordRepeat != $password){
            $errors['psw-repeat'] = 'Пароли не совпадают!';
        }
    } else {
        $errors['psw-repeat'] = 'Поле не должно быть пустым';
    }
//проверка на повторяющуюся почту
    $pdo = new PDO("pgsql:host=db; port=5432; dbname=laravel","root", "root");
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email'=>$email]);
    $user = $stmt->fetch();

    if ($user){
        $errors['email'] = 'Пользователь с таким адресом почты уже существует';
    }
    return $errors;
}

$errors = validation($_POST);

if (empty($errors)){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['psw'];
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
    $user = $stmt->fetch();

    header("Location: /login.php");
}

require_once ('./registration.php');