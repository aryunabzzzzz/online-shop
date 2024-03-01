<?php
function validation(array $arr):array
{
    $errors = [];

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

    return $errors;
}

$errors = validation($_POST);


if (empty($errors)){
    $email = $_POST['email'];
    $password = $_POST['psw'];
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
            session_start();
            $_SESSION['user_id'] = $user['id'];
            header("Location: /main");
        } else {
            $errors['email'] = 'Неправильный адрес почты или пароль';
        }
    }
}

require_once ('./login.php');