<?php
//El auth middleware se encarga de que todos los usuarios estén autentificados antes de entrar a cualquier ruta.
//En este caso para validar el token jwt y proteger las rutas de la api.

require '../utils/jwt.php';

function authenticate() {
    //Obtiene todos los headers
    $headers = getallheaders();
    
    //Verifica que el header "authorizarion" esté presente, obligatoriamente debe llamarse así
    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(["error" => "Acceso no autorizado"]);
        exit;
    }
    
    //Extrae el token del header, ya que el token va justo despues de la palabra "Bearer"
    $token = str_replace('Bearer ', '', $headers['Authorization']);
    //Llama a la función que valida el token que está en jwt.php
    $decoded = validateJWT($token);
    
    if (!$decoded) {
        http_response_code(401);
        echo json_encode(["error" => "Token inválido o expirado"]);
        exit;
    }
    
    //Se retorna el id del usario para que cada controlador pueda usarlo, el id del usuario se 
    //guarda en el campo llamado "sub" dentro del objeto "payload" de la función validateJWT.
    return $decoded->sub;
}

?>