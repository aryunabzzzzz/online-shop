<?php

namespace Request;

class OrderRequest extends Request
{
    public function getFullName()
    {
        return $this->body['fullName'];
    }

    public function getPhone()
    {
        return $this->body['phone'];
    }

    public function getAddress()
    {
        return $this->body['address'];
    }

    public function validate(): array
    {
        $errors = [];

        $data = $this->body;

        if (empty($data['fullName'])){
            $errors['fullName'] = 'Поле не должно быть пустым';
        } else {
            $fullName = $data['fullName'];
            if (!preg_match("/^[a-zA-Z-' ]*$/",$fullName)) {
                $errors['fullName'] = "Поле должно содержать только буквы и пробелы";
            }
        }

        if (empty($data['phone'])){
            $errors['phone'] = 'Поле не должно быть пустым';
        } else {
            $phone = $data['phone'];
            if (!preg_match("/^(\+7|7|8)?[\s\-]?\(?[489][0-9]{2}\)?[\s\-]?[0-9]{3}[\s\-]?[0-9]{2}[\s\-]?[0-9]{2}$/",$phone)) {
                $errors['phone'] = "Неккоректный номер телефона";
            }
        }

        if (empty($data['address'])){
            $errors['address'] = 'Поле не должно быть пустым';
        } else {
            $address = $data['address'];
            if (!preg_match("/^[a-zA-Z-' ]*$/",$address)) {
                $errors['address'] = "Поле должно содержать только буквы и пробелы";
            }
        }

        return $errors;
    }

}