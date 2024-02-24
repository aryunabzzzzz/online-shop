<?php
//объявление переменных из полученного массива
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['psw'];
$passwordRepeat = $_POST['psw-repeat'];

//процедура валидации
if (strlen($name)<3){
    print_r("Слишком короткое имя пользователя");
    return;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    print_r("Некорректно введён email");
    return;
}

if ($password!=$passwordRepeat){
    print_r("Пароли не совпадают!");
    return;
}
//создание объекта класса
$pdo = new PDO("pgsql:host=db; port=5432; dbname=laravel","root", "root");

//добавление данных пользователя в БД + защита от SQL-инъекции
$stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
$stmt->execute(['name'=>$name, 'email'=>$email, 'password'=>$password]);
//возврат данных пользователя на экран
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(['email'=>$email]);
$result = $stmt->fetch();
print_r($result);
