<?php

namespace Controller;

use Model\User;
use Entity\UserEntity;

class UserController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function getRegistration(): void
    {
        require_once ('./../View/registration.php');
    }

    public function postRegistration(array $data): void
    {
        $errors = $this->validateRegistration($data);

        if (empty($errors)){
            $name = $data['name'];
            $email = $data['email'];
            $password = $data['psw'];

            $password = password_hash($password, PASSWORD_DEFAULT);

            $this->userModel->create($name, $email, $password);

            header("Location: /login");
        }

        require_once ('./../View/registration.php');
    }

    private function validateRegistration(array $data):array
    {
        $errors = [];

        if (empty($data['name'])){
            $errors['name'] = 'Поле не должно быть пустым';
        } else {
            $name = $data['name'];
            if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
                $errors['name'] = "Поле должно содержать только буквы и пробелы";
            }
        }

        if (empty($data['email'])){
            $errors['email'] = 'Поле не должно быть пустым';
        } else {
            $email = $data['email'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Некорректно введён email";
            } else {
                if ($this->userModel->getOneByEmail($email)){
                    $errors['email'] = 'Пользователь с таким адресом почты уже существует';
                }
            }
        }

        if (empty($data['psw'])) {
            $errors['psw'] = 'Поле не должно быть пустым';
        } else {
            $password = $data['psw'];
            if (strlen($password)<3){
                $errors['psw'] = 'Слишком короткий пароль';
            }
        }

        if (empty($data['psw-repeat'])) {
            $errors['psw-repeat'] = 'Поле не должно быть пустым';
        } else {
            $passwordRepeat = $data['psw-repeat'];
            if ($passwordRepeat !== $password){
                $errors['psw-repeat'] = 'Пароли не совпадают!';
            }
        }

        return $errors;
    }

    public function getLogin(): void
    {
        require_once ('./../View/login.php');
    }

    public function postLogin(array $data): void
    {
        $errors = $this->validationLogin($data);

        if (empty($errors)){
            $email = $data['email'];
            $password = $data['psw'];

            $user = $this->userModel->getOneByEmail($email);

            if (!$user){
                $errors['email'] = 'Пользователя с таким адресом почты не существует';
            } else {
                if (password_verify($password, $user->getPassword())){
                    session_start();
                    $_SESSION['user_id'] = $user->getId();
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

    public function getLogout(): void
    {
        session_start();
        if (session_status() === PHP_SESSION_ACTIVE){
            session_destroy();
        }
        header('Location: /login');
    }

}