<?php

require '../config.php';
require '../utils/jwt.php';

//Establece las respuestas como json
header('Content-Type: application/json');

//Obtiene los datos de la solicitud POST y los decodifica como un array
$data = json_decode(file_get_contents("php://input"), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    if ($_GET['action'] === 'register') {
        $name = $data['name'] ?? '';
        $email = $data['email'] ?? '';
        $password = password_hash($data['password'] ?? '', PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $email, $password])) {
            echo json_encode(["message" => "Usuario registrado exitosamente"]);
        } else {
            echo json_encode(["error" => "Error al registrar usuario"]);
        }
    }
    elseif ($_GET['action'] === 'login') {
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        //Obtiene el resultado de la consulta como un array
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            //Llama a la función generateJWT y le pasa el id del usuario como parámetro para generar el token
            $token = generateJWT($user['id']);
            //Imprime el token
            echo json_encode(["token" => $token]);
        } else {
            echo json_encode(["error" => "Credenciales inválidas"]);
        }
    }
} else {
    echo "Ha ocurrido un error";
}

?>