<?php

namespace learn\php\simple_todo_list\util;


class Database {
    private static $connection = null;

    public static function getConnection() {
        if (!self::$connection) {
            try {
                // Adjust with your database credentials
                $dsn = 'mysql:host=localhost;dbname=todo_list';
                $username = 'root';
                $password = '';
                self::$connection = new \PDO($dsn, $username, $password);
                self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

                // Create the tasks table if it doesn't exist
                self::createTasksTableIfNotExists();
            } catch (\PDOException $e) {
                die('Database connection error: ' . $e->getMessage());
            }
        }
        return self::$connection;
    }

    // Function to create the tasks table if it does not exist
    private static function createTasksTableIfNotExists() {
        $sql = "
            CREATE TABLE IF NOT EXISTS tasks (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                completed BOOLEAN DEFAULT FALSE
            ) ENGINE=InnoDB;
        ";

        try {
            self::$connection->exec($sql);
        } catch (\PDOException $e) {
            die('Error creating tasks table: ' . $e->getMessage());
        }
    }
}
