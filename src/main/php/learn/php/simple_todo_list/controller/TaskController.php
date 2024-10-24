<?php

namespace learn\php\simple_todo_list\controller;

use learn\php\simple_todo_list\model\TaskManager;

class TaskController {
    private $taskManager;

    public function __construct() {
        $this->taskManager = new TaskManager();
    }

    //REM: Pagination logic and task retrieval
    public function index($currentPage) {
        $tasksPerPage = 5; //REM: Number of tasks per page
        $totalTasks = $this->taskManager->getTotalTasks(); //REM: Get total tasks
        $totalPages = ceil($totalTasks / $tasksPerPage?? $totalTasks ); //REM: Calculate total pages

        //REM: Ensure current page is within bounds
        $currentPage = max(1, min($currentPage, $totalPages));

        //REM: Calculate the OFFSET for the SQL query
        $offset = ($currentPage - 1) * $tasksPerPage;

        //REM: Get tasks for the current page
        $tasks = $this->taskManager->getTasks($tasksPerPage, $offset);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['task'])) {
                $newTask = trim($_POST['task']);
                if (!empty($newTask)) {
                    $this->taskManager->addTask($newTask);
                }
            }
        
            if (isset($_POST['complete'])) {
                $id = intval($_POST['complete']);
                $this->taskManager->completeTask($id);
            }
        
            if (isset($_POST['undo'])) {
                $id = intval($_POST['undo']);
                $this->taskManager->incompleteTask($id);
            }
            header("location: ?page=$currentPage");
        }

        return ['tasks' => $tasks, 'totalPages' => $totalPages, 'currentPage' => $currentPage];
    }
}
