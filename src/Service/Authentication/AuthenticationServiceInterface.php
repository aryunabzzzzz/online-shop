<?php

namespace Service\Authentication;

use Entity\UserEntity;

interface AuthenticationServiceInterface
{
    public function check(): bool;
    public function getCurrentUser(): UserEntity|null;
    public function login(string $email, string $password): bool;
    public function logout(): void;
}