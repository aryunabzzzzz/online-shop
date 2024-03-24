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

}