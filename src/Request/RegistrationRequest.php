<?php

namespace Request;

use Repository\UserRepository;

class RegistrationRequest extends Request
{
    private UserRepository $userRepository;

    public function __construct(string $method, string $uri, array $headers, array $body)
    {
        parent::__construct($method, $uri, $headers, $body);

        $this->userRepository = new UserRepository();
    }
    public function getName()
    {
        return $this->body['name'];
    }

    public function getEmail()
    {
        return $this->body['email'];
    }

    public function getPassword()
    {
        return $this->body['psw'];
    }

    public function validate():array
    {
        $errors = [];

        $data = $this->body;

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
                if ($this->userRepository->getOneByEmail($email)){
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

}