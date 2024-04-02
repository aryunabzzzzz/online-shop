<?php

namespace Request;

class LoginRequest extends Request
{
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

        if (empty($data['email'])){
            $errors['email'] = 'Поле не должно быть пустым';
        } else {
            $email = $data['email'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Некорректно введён email";
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

        return $errors;
    }

}