<?php
//процедура валидации
function validateRegistration(array $arr):array
{
    $errors = [];

    if (empty($arr['name'])){
        $errors['name'] = 'Поле не должно быть пустым';
    } else {
        $name = $arr['name'];
        if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
            $errors['name'] = "Поле должно содержать только буквы и пробелы";
        }
    }

    if (empty($arr['email'])){
        $errors['email'] = 'Поле не должно быть пустым';
    } else {
        $email = $arr['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Некорректно введён email";
        } else {
            $pdo = new PDO("pgsql:host=db; port=5432; dbname=laravel","root", "root");
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email'=>$email]);
            $user = $stmt->fetch();

            if ($user){
                $errors['email'] = 'Пользователь с таким адресом почты уже существует';
            }
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

    if (empty($arr['psw-repeat'])) {
        $errors['psw-repeat'] = 'Поле не должно быть пустым';
    } else {
        $passwordRepeat = $arr['psw-repeat'];
        if ($passwordRepeat !== $password){
            $errors['psw-repeat'] = 'Пароли не совпадают!';
        }
    }

    return $errors;
}

$errors = validateRegistration($_POST);

if (empty($errors)){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['psw'];

    //защита пароля
    $password = password_hash($password, PASSWORD_DEFAULT);

    //создание объекта класса
    $pdo = new PDO("pgsql:host=db; port=5432; dbname=laravel","root", "root");

    //добавление данных пользователя в БД + защита от SQL-инъекции
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->execute(['name'=>$name, 'email'=>$email, 'password'=>$password]);
    //возврат данных пользователя на экран
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email'=>$email]);
    $user = $stmt->fetch();

    header("Location: /login");
}

require_once ('./registration.php');