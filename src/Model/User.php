<?php

namespace Model;

class User extends Model
{
    public function getOneByEmail(string $email): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email'=>$email]);
        $user = $stmt->fetch();

        return($user);
    }

    public function create(string $name, string $email, string $password): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name'=>$name, 'email'=>$email, 'password'=>$password]);
    }
}