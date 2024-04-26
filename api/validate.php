<?php
    
    require_once 'jwt/src/JWTExceptionWithPayloadInterface.php';
    require_once 'jwt/src/ExpiredException.php';
    require_once 'jwt/src/SignatureInvalidException.php';
    require_once 'jwt/src/JWT.php';
    require_once 'jwt/src/Key.php';
    use \Firebase\JWT\JWT;
    use \Firebase\JWT\Key;
    
    require_once 'key.php';  // contains the secretKey to encode and decode JWT.....
    
    // header("Access-Control-Allow-Headers: Authorization"); // make changes in htaccess file and restart server to allow this
    
    $token_valid =0;
    $token = null;
    $headers = apache_request_headers();
    if (isset($headers['Authx'])) {
        $authHeader = $headers['Authx'];
        $tokenParts = explode(" ", $authHeader);
        if (count($tokenParts) == 2 && $tokenParts[0] == 'Bearer') {
            $token = $tokenParts[1];
        }
    }
    // Validate the token
    if ($token) {
        try {
            $algorithm = (object) ['algorithm' => 'HS256'];
            $decoded = JWT::decode($token, new Key($mySecretKey, 'HS256'));
            $token_valid =1;
            // echo "Token is valid.";
        } catch (Exception $e) {
            // $response["response"] = "Token is invalid: " . $e->getMessage();
            $response["response"] = "Token is invalid..!!";
            header('Content-Type: application/json');
            echo json_encode($response);
            exit(-1);
        }
    } else {
        $response["response"] = "Token is missing..!!";
        header('Content-Type: application/json');
        echo json_encode($response);
        exit(-1);
    }
    
    
?>