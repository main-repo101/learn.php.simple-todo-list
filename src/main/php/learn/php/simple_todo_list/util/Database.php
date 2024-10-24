<?php

namespace learn\php\simple_todo_list\util;

use Dotenv\Dotenv;

class Database
{
    private static \PDO|null $connection = null;

    public static function getConnection(): \PDO | null
    {
        if (!self::$connection) {
            try {

                $dotenv = Dotenv::createImmutable(
                    __DIR_ROOT,
                    [".env.test", ".env.dev", ".env.local", ".env"]
                );
                $dotenv->load();

                $host = $_ENV['LEARN_PHP_DB_HOST'];
                $dbname = $_ENV['LEARN_PHP_DB_NAME'];
                $username = $_ENV['LEARN_PHP_DB_USER'];
                $password = $_ENV['LEARN_PHP_DB_PASS'];

                //REM: Adjust with your database credentials
                $dsn = "mysql:host=$host;dbname=$dbname";
                self::$connection = new \PDO($dsn, $username, $password);
                self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

                //REM: Create the tasks table if it doesn't exist
                self::createTasksTableIfNotExists();
            } catch (\PDOException $e) {
                // die('Database connection error: ' . $e->getMessage());
            }
        }
        return self::$connection;
    }

    //REM: Function to create the tasks table if it does not exist
    private static function createTasksTableIfNotExists(): bool | int
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS tasks (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                completed BOOLEAN DEFAULT FALSE,
                create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                update_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB;
        ";

        try {
            return self::$connection->exec($sql);
        } catch (\PDOException $e) {
            // die('Error creating tasks table: ' . $e->getMessage());
        }
        return false;
    }
}
