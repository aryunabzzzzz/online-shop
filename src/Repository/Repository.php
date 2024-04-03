<?php

namespace Repository;

use PDO;

class Repository
{
    protected static PDO $pdo;

    public static function getPdo(): PDO
    {
        if (isset(self::$pdo)){
            return self::$pdo;
        }

        $db = getenv('DB_DATABASE');
        $user = getenv('DB_USERNAME');
        $password = getenv('DB_PASSWORD');

        self::$pdo = new PDO("pgsql:host=db; port=5432; dbname=$db","$user", "$password");

        return self::$pdo;
    }
}