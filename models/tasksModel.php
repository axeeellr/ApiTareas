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

//Actualizar, editar, etc...

?>
