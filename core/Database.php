<?php
namespace Core;

use PDO;

class Database {
    private static ?PDO $connection = null;
    
    public static function init(): void {
        $dsn = "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}";
        self::$connection = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }
    
    public static function query(string $sql, array $params = []): \PDOStatement {
        $stmt = self::$connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}