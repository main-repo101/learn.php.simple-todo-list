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

    public function getTotalTasks(): int {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM tasks");
            return $stmt->fetchColumn();
        } catch (\PDOException | \Exception | \Error $e) {
            
        }
        return -1;
    }

    public function addTask($title): bool {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO tasks (title, completed) VALUES (:title, 0)");
            $stmt->bindParam(':title', $title, \PDO::PARAM_STR);
            return $stmt->execute();
        } catch (\PDOException | \Exception | \Error $e) {
            
        }
        return false;
    }

    public function completeTask($id): bool {
        try {
            $stmt = $this->pdo->prepare("UPDATE tasks SET completed = 1 WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (\PDOException | \Exception | \Error $e) {
            
        }
        return false;
    }

    public function incompleteTask($id): bool {
        try {
            $stmt = $this->pdo->prepare("UPDATE tasks SET completed = 0 WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (\PDOException | \Exception | \Error $e) {
            
        }
        return false;
    }

    public function getTasks($limit, $offset): array {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM tasks ORDER BY id DESC LIMIT :limit OFFSET :offset");
            $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException | \Exception | \Error $e) {
            
        }
        return [];
    }

    
    public function searchTasks(string $searchTerm, bool $isCaseSensitive = false): array {
        //REM: Clean and prepare search term (trim and sanitize)
        $searchTerm = trim($searchTerm);
        if (empty($searchTerm))
            return []; //REM: Return empty array if the search term is empty
    
        //REM: Default query
        $query = "SELECT * FROM tasks WHERE title LIKE :searchTerm ORDER BY id DESC";
    
        //REM: If case sensitivity is required, modify the query to use BINARY for case-sensitive search
        if ($isCaseSensitive)
            $query = "SELECT * FROM tasks WHERE BINARY title LIKE :searchTerm ORDER BY id DESC";
    
        try {
            //REM: Prepare the query
            $stmt = $this->pdo->prepare($query);
    
            //REM: Add wildcards for partial match
            $searchTerm = '%' . $searchTerm . '%';
    
            //REM: Bind the parameter and execute the query
            $stmt->bindParam(':searchTerm', $searchTerm, \PDO::PARAM_STR);
            $stmt->execute();
    
            //REM: Return the fetched results
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    
        } catch (\PDOException | \Exception | \Error $e) {
            //REM: Log the error with more detail or rethrow the exception based on your application needs
            error_log('Search task error: ' . $e->getMessage());
            throw new \RuntimeException('Failed to search tasks: ' . $e->getMessage());
        }
    }
    
    
    public function editTask($id, $newTitle): bool {
        try {
            $stmt = $this->pdo->prepare("UPDATE tasks SET title = :newTitle WHERE id = :id");
            $stmt->bindParam(':newTitle', $newTitle, \PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException | \Exception | \Error $e) {
            
        }
        return false;
    }
    
    public function deleteTask($id): bool {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM tasks WHERE id = :id");
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);  
            return $stmt->execute();
        } catch (\PDOException | \Exception | \Error $e) {
            
        }
        return false;
    }
}
