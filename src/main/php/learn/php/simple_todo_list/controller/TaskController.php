<?php

namespace learn\php\simple_todo_list\controller;

use learn\php\simple_todo_list\model\TaskManager;

class TaskController
{
    private TaskManager $taskManager;
    private int $limitView;

    public function __construct(int $limitView)
    {
        $this->taskManager = new TaskManager();
        $this->limitView = $limitView;
    }

    public function getTaskManager(): TaskManager
    {
        return $this->taskManager;
    }

    //REM: Pagination logic and task retrieval
    public function index($currentPage): array
    {

        if (!$this->taskManager->isConnectionSucceeded())
            return [
                'tasks' => [],
                'totalPages' => 0,
                'currentPage' => 0,
                'status' => [
                    'code' => 123,
                    'message' => 'Connection Failed.'
                ]
            ];


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

            if (isset($_POST['btn_delete'])) {
                $id = intval($_POST['btn_delete']);
                $this->taskManager->deleteTask($id);
            }

            if (isset($_POST['btn_save'])) {
                $id = intval($_POST['btn_save']);
                $this->taskManager->editTask($id, $_POST['text_edit']);
            }

            header("location: ?page=$currentPage");
        }

        $tasksPerPage = $this->limitView; //REM: Number of tasks per page
        $totalTasks = $this->taskManager->getTotalTasks(); //REM: Get total tasks
        $totalPages = ceil($totalTasks / $tasksPerPage ?? $totalTasks); //REM: Calculate total pages

        //REM: Ensure current page is within bounds
        $currentPage = max(1, min($currentPage, $totalPages));

        //REM: Calculate the OFFSET for the SQL query
        $offset = ($currentPage - 1) * $tasksPerPage;

        //REM: Get tasks for the current page
        $tasks = $this->taskManager->getTasks($tasksPerPage, $offset);


        return [
            'tasks' => $tasks,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage,
            'status' => [
                'code' => 0,
                'message' => 'Connection Succeeded.'
            ]
        ];
    }
}
