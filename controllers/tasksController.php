<?php
//Task controller es el que recibe las solicitudes y llama a los modelos para poder hacerlas

require '../models/tasksModel.php';

// Obtener todas las tareas de un usuario
function getTasks($user_id) {
    $tasks = fetchTasks($user_id);
    echo json_encode($tasks);
}

// Crear una tarea
function createTask($user_id) {
    $data = json_decode(file_get_contents("php://input"), true);
    $title = $data['title'] ?? '';
    $description = $data['description'] ?? '';
    
    $task_id = addTask($user_id, $title, $description);
    
    if ($task_id) {
        echo json_encode(["message" => "Tarea creada exitosamente", "task_id" => $task_id]);
    } else {
        echo json_encode(["error" => "Error al crear la tarea"]);
    }
}

//Editar tareas, eliminar, filtrar, etc...
?>
