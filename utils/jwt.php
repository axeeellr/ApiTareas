<?php

    //Llama al archivo "autoload" de composer para usar las dependencias necesarias
    require '../vendor/autoload.php';
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    //Define la clave secreta si es que hay alguna o usa "secreto" por defecto
    $key = getenv('JWT_SECRET') ?: 'secreto';

    function generateJWT($user_id) {
        //Define key como global para poder usarla donde sea
        global $key;

        //Se define la información que va a guardar el token, en este caso guardamos el emisor del token, la
        //audiencia, o sea, quien usará el token, la fecha de creación y expiración (una hora) y el id del usuario
        $payload = [
            'iss' => "api", 
            'aud' => "api_users", 
            'iat' => time(),
            'exp' => time() + (60 * 60), 
            'sub' => $user_id
        ];

        //Genera el token usando lo que creamos antes y el algoritmo hs256 que funciona como 
        //una firma y/o verificacion de autenticidad
        return JWT::encode($payload, $key, 'HS256');
    }

    function validateJWT($token) {
        global $key;
        try {
            //Retorna el token decodificado, o sea, el contenido del token, se usa la key y la firma
            return JWT::decode($token, new Key($key, 'HS256'));
        } catch (Exception $e) {
            return null;
        }
    }

?>