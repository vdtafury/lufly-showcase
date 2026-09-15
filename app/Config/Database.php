<?php
declare(strict_types=1);

namespace App\Config;

use PDO;
use PDOException;
use RuntimeException;

class Database
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance !== null) {
            return self::$instance;
        }

        $dbDriver = getenv('DB_DRIVER') ?: 'sqlite';

        if ($dbDriver === 'mysql') {
            $host = getenv('DB_HOST') ?: '127.0.0.1';
            $port = getenv('DB_PORT') ?: '3306';
            $db   = getenv('DB_DATABASE') ?: 'lufly_production';
            $user = getenv('DB_USERNAME') ?: 'root';
            $pass = getenv('DB_PASSWORD') ?: '';
            $charset = 'utf8mb4';

            $dsn = "mysql:host={$host};port={$port};dbname={$db};charset={$charset}";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                throw new RuntimeException("MySQL connection failed: " . $e->getMessage());
            }
        } else {
            // SQLite
            $defaultDbPath = dirname(__DIR__, 2) . '/database/lufly_production.db';
            $sqlitePath = getenv('DB_PATH') ?: $defaultDbPath;

            if (!file_exists($sqlitePath)) {
                throw new RuntimeException("SQLite database not found at: {$sqlitePath}");
            }

            try {
                self::$instance = new PDO("sqlite:" . $sqlitePath);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                self::$instance->exec("PRAGMA foreign_keys = ON;");
            } catch (PDOException $e) {
                throw new RuntimeException("SQLite connection failed: " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
