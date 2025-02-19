<?php

require '../middleware/authMiddleware.php';
require '../controllers/tasksController.php';

// Llama a la función authenticate para verificar que el usuario esté autenticado.
//Esa función retorna el id del usuario
$user_id = authenticate();

// Verifica el método de la solicitud y hace la acción correspondiente
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Obtener todas las tareas
        getTasks($user_id);
        break;

    case 'POST':
        // Crear una nueva tarea
        createTask($user_id);
        break;
        
    //DELETE, PUT, etc...
    default:
        echo "Ha ocurrido un error";
}

?>
