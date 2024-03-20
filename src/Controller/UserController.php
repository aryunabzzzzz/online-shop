<?php

namespace Controller;

use http\Env\Request;
use Repository\UserRepository;
use Request\LoginRequest;
use Request\RegistrationRequest;

class UserController
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function getRegistration(): void
    {
        require_once ('./../View/registration.php');
    }

    public function postRegistration(RegistrationRequest $request): void
    {
        $errors = $request->validate();

        if (empty($errors)){
            $name = $request->getName();
            $email = $request->getEmail();
            $password = $request->getPassword();

            $password = password_hash($password, PASSWORD_DEFAULT);

            $this->userRepository->create($name, $email, $password);

            header("Location: /login");
        }

        require_once ('./../View/registration.php');
    }

    public function getLogin(): void
    {
        require_once ('./../View/login.php');
    }

    public function postLogin(LoginRequest $request): void
    {
        $errors = $request->validate();

        if (empty($errors)){
            $email = $request->getEmail();
            $password = $request->getPassword();

            $user = $this->userRepository->getOneByEmail($email);

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

    public function getLogout(): void
    {
        session_start();
        if (session_status() === PHP_SESSION_ACTIVE){
            session_destroy();
        }
        header('Location: /login');
    }

}