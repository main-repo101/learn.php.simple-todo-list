<?php
//REM: [TODO, NOT_WORKING]

namespace learn\php\simple_todo_list\util;

// use learn\php\simple_todo_list\model\TaskManager;

header('Content-Type: application/json');

//REM: Check if 'id' is set in POST
if (!isset($_POST['id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Task ID is missing.',
    ]);
    exit();
}

$id = $_POST['id'];
$response = [
    'status' => 'error',
    'message' => 'Failed to delete task',
];

if( !isset($taskManger) ) {
    $response["message"] = $response["message"] . ", TaskManger is not set";
    echo json_encode($response);
    exit();
}

if ( $taskManager->deleteTask((int)$id)) {
    $response = [
        'status' => 'success',
        'message' => 'Task deleted successfully',
    ];
}


//REM: Return JSON response
echo json_encode($response);
exit();
