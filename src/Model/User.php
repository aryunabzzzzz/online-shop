<?php

class User extends Model
{
    public function getOneByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email'=>$email]);
        $user = $stmt->fetch();

        return($user);
    }

    public function create($name, $email, $password)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name'=>$name, 'email'=>$email, 'password'=>$password]);
    }
}