<?php
require_once __DIR__ . "/src/main/php/learn/php/simple_todo_list/autoload_config.php";

use learn\php\simple_todo_list\controller\TaskController;

//REM: Initialize controller
$taskController = new TaskController(5);
$taskManager = $taskController->getTaskManager();

//REM: Get current page from query parameters (default to 1)
$currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

//REM: Get data for the current page
$data = $taskController->index($currentPage);
$tasks = $data['tasks'];
$totalPages = $data['totalPages'];
$currentPage = $data['currentPage'];
$status = $data['status'];

$TITLE = "Eco-Friendly ✅To-Do List";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/resource/css/global-style.css">
    <link rel="stylesheet" href="public/resource/css/task-list.css">
    <link rel="icon" href="public/resource/img/img-icon-leaf-check-360x360-000.png">
    <title><?= isset($TITLE)? $TITLE : "<unknown-to-do-list>"?></title>
</head>

<body>
    <div class="container">
        <?php include __DIR_VIEW . '/component/header.php'; ?>

        <?php include __DIR_VIEW . '/component/interactive-bar.php'; ?>

        <?php include __DIR_VIEW . '/component/task-list.php'; ?>

        <?php include __DIR_VIEW . '/component/pagination.php'; ?>
    </div>
</body>
<script src="public/resource/js/task-list.js"></script>
</html>