<?php

namespace Repository;

use PDO;

class Repository
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO("pgsql:host=db; port=5432; dbname=laravel","root", "root");
    }

    public function beginTransaction(): bool
    {
        return $this->pdo->beginTransaction();
    }

    public function rollbackTransaction(): bool
    {
        return $this->pdo->rollBack();
    }

    public function commitTransaction(): bool
    {
        return $this->pdo->commit();
    }
}