<?php
function validationLogin(array $arr):array
{
    $errors = [];

    if (empty($arr['email'])){
        $errors['email'] = 'Поле не должно быть пустым';
    } else {
        $email = $arr['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Некорректно введён email";
        }
    }

    if (empty($arr['psw'])) {
        $errors['psw'] = 'Поле не должно быть пустым';
    } else {
        $password = $arr['psw'];
        if (strlen($password)<3){
            $errors['psw'] = 'Слишком короткий пароль';
        }
    }

    return $errors;
}

$errors = validationLogin($_POST);


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