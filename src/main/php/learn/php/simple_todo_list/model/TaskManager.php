<?php

namespace learn\php\simple_todo_list\model;

use learn\php\simple_todo_list\util\Database;

class TaskManager {
    private \PDO|null $pdo = null;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function isConnectionSucceeded(): bool {
        return $this->pdo !== null;
    }

    //REM: Get the total number of tasks
    public function getTotalTasks(): int {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM tasks");
            return $stmt->fetchColumn();
        } catch (\PDOException | \Exception | \Error $e) {
            // die('Error retrieving task count: ' . $e->getMessage());
        }
        return -1;
    }

    public function addTask($title): bool {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO tasks (title, completed) VALUES (:title, 0)");
            $stmt->bindParam(':title', $title, \PDO::PARAM_STR);
            return $stmt->execute();
        } catch (\PDOException | \Exception | \Error $e) {
            // die('Error adding new task: ' . $e->getMessage());
        }
        return false;
    }


    // Mark a task as complete
    public function completeTask($id): bool {
        try {
            $stmt = $this->pdo->prepare("UPDATE tasks SET completed = 1 WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (\PDOException | \Exception | \Error $e) {
            // Handle any SQL query errors
            // die('Error completing task: ' . $e->getMessage());
        }
        return false;
    }

    // Mark a task as incomplete
    public function incompleteTask($id): bool {
        try {
            $stmt = $this->pdo->prepare("UPDATE tasks SET completed = 0 WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (\PDOException | \Exception | \Error $e) {
            // Handle any SQL query errors
            // die('Error marking task as incomplete: ' . $e->getMessage());
        }
        return false;
    }

    //REM: Get tasks with pagination
    public function getTasks($limit, $offset): array {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM tasks ORDER BY id DESC LIMIT :limit OFFSET :offset");
            $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException | \Exception | \Error $e) {
            // die('Error retrieving tasks: ' . $e->getMessage());
        }
        return [];
    }
}
