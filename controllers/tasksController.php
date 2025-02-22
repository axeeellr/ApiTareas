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

//Actualizar una tarea
function updateTask($user_id, $task_id){
    $data = json_decode(file_get_contents("php://input"), true);
    $title = $data['title'] ?? '';
    $description = $data['description'] ?? '';
    $status = $data['status'] ?? 'pendiente';

    if (editTask($user_id, $title, $description, $status, $task_id)) {
        echo json_encode(["message" => "Tarea actualizada exitosamente"]);
    }else{
        echo json_encode(["error" => "Error al actualizar la tarea"]);
    }
}

//Eliminar tarea
function deleteTask($user_id, $task_id){
    if (removeTask($user_id, $task_id)) {
        echo json_encode(["message" => "Tarea eliminada exitosamente"]);
    }else{
        echo json_encode(["error" => "Error al eliminar la tarea"]);
    }
}
?>
