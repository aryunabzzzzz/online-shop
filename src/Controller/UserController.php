<?php

class UserController
{
    private User $userModel;

    public function __construct()
    {
        require_once './../Model/User.php';
        $this->userModel = new User();
    }

    public function getRegistration()
    {
        require_once ('./../View/registration.php');
    }

    public function postRegistration()
    {
        $errors = $this->validateRegistration($_POST);

        if (empty($errors)){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['psw'];

            $password = password_hash($password, PASSWORD_DEFAULT);

            $this->userModel->create($name, $email, $password);

            header("Location: /login");
        }

        require_once ('./../View/registration.php');
    }

    private function validateRegistration(array $arr):array
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
                if ($this->userModel->getOneByEmail($email)){
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

    public function getLogin()
    {
        require_once ('./../View/login.php');
    }

    public function postLogin()
    {
        $errors = $this->validationLogin($_POST);

        if (empty($errors)){
            $email = $_POST['email'];
            $password = $_POST['psw'];

            $user = $this->userModel->getOneByEmail($email);

            if (!$user){
                $errors['email'] = 'Пользователя с таким адресом почты не существует';
            } else {
                if (password_verify($password, $user['password'])){
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    header("Location: /main");
                } else {
                    $errors['email'] = 'Неправильный адрес почты или пароль';
                }
            }
        }

        require_once ('./../View/login.php');
    }

    private function validationLogin(array $arr):array
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

}