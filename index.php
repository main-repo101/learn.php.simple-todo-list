<?php
require_once __DIR__ . "/src/main/php/learn/php/simple_todo_list/autoload_config.php";

use learn\php\simple_todo_list\controller\TaskController;

//REM: Initialize controller
$taskController = new TaskController();

//REM: Get current page from query parameters (default to 1)
$currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

//REM: Get data for the current page
$data = $taskController->index($currentPage);
$tasks = $data['tasks'];
$totalPages = $data['totalPages'];
$currentPage = $data['currentPage'];
$status = $data['status'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/resource/css/global-style.css">
    <title>Eco-Friendly To-Do List</title>
</head>

<body>
    <div class="container">
        <?php if( isset($status) && $status['code'] !== 0 ): ?>
            <div class="pnl-note-error">
                <h3 class="lbl-note-error connectivity">
                    <?= $status['message']?? '' ?>
                </h3>
            </div>
        <?php endif; ?>
        <h1>🌱 Eco-Friendly To-Do List 🌱</h1>
        
        <form method="POST" class="task-form">
            <input type="text" name="task" placeholder="Add a new eco-friendly task">
            <button type="submit">Add Task</button>
        </form>

        <ul class="task-list">
            <?php foreach ($tasks as $task): ?>
                <li class="<?php echo $task['completed'] ? 'completed' : ''; ?>">
                    <form method="POST" class="task-item">
                        <!-- <textarea class="lbl-task-item"> -->
                            <?= htmlspecialchars($task['title']) ?>
                        <!-- </textarea> -->
                        <button 
                            class="btn-task-item"
                            type="submit" 
                            name="<?php echo $task['completed'] ? 'undo' : 'complete'; ?>" 
                            value="<?php echo $task['id']; ?>">
                            <?php echo $task['completed'] ? 'Undo' : 'Complete'; ?>
                        </button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php include 'src/main/php/learn/php/simple_todo_list/view/component/pagination.php'; ?>
    </div>
</body>

</html>