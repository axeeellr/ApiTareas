<?php

require '../config.php';

// Obtener tareas de un usuario
function fetchTasks($user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Crear una tarea
function addTask($user_id, $title, $description) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description) VALUES (?, ?, ?)");
    if ($stmt->execute([$user_id, $title, $description])) {
        return $conn->lastInsertId();
    }
    return false;
}

//Actualizar tarea
function editTask($user_id, $title, $description, $status, $task_id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE tasks SET title = ?, description = ?, status = ? WHERE id = ? AND user_id = ?");
    return $stmt->execute([$title, $description, $status, $task_id, $user_id]);
}

//Eliminar tarea
function removeTask($user_id, $task_id){
    global $conn;
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    return $stmt -> execute([$task_id, $user_id]);
}
?>
