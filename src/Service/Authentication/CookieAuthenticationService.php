<?php

namespace Service\Authentication;

use Entity\UserEntity;
use Repository\UserRepository;

class CookieAuthenticationService implements AuthenticationServiceInterface
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function check(): bool
    {
        return isset($_COOKIE['user_id']);
    }

    public function getCurrentUser(): UserEntity|null
    {
        if ($this->check()){
            $userId = $_COOKIE['user_id'];

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
            setcookie("user_id", $user->getId(), time() + 3600);

            return true;
        }

        return false;
    }

    public function logout(): void
    {
        setcookie("user_id", "", time() - 3600);
    }

}