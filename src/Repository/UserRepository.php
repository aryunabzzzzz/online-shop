<?php

namespace Repository;

use Entity\UserEntity;

class UserRepository extends Repository
{
    public function getOneByEmail(string $email): UserEntity|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email'=>$email]);
        $user = $stmt->fetch();

        if (!$user){
            return null;
        }

        return $this->hydrate($user);
    }

    public function getOneById(int $userId): UserEntity|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id'=>$userId]);
        $user = $stmt->fetch();

        if (!$user){
            return null;
        }

        return $this->hydrate($user);
    }

    public function create(string $name, string $email, string $password): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name'=>$name, 'email'=>$email, 'password'=>$password]);
    }

    public function hydrate(array $data): UserEntity
    {
        return new UserEntity($data['id'], $data['name'], $data['email'], $data['password']);
    }
}