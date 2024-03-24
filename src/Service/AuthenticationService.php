<?php

namespace Service;

use Entity\UserEntity;
use Repository\UserRepository;

class AuthenticationService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }
    public function check(): bool
    {
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }

        return isset($_SESSION['user_id']);
    }

    public function getCurrentUser(): UserEntity|null
    {
        if ($this->check()){
            $userId = $_SESSION['user_id'];

            return $this->userRepository->getOneById($userId);
        }

        return null;
    }

    public function login(string $email, string $password): bool
    {
        $user = $this->userRepository->getOneByEmail($email);

        if (!$user){
            return false;
        }

        if (password_verify($password, $user->getPassword())){
            session_start();
            $_SESSION['user_id'] = $user->getId();

            return true;
        }

        return false;
    }

    public function logout(): void
    {
        session_start();
        if (session_status() === PHP_SESSION_ACTIVE){
            session_destroy();
        }
    }

}