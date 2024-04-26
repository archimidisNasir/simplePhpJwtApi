<?php

require_once 'key.php';
require_once 'jwt/src/JWT.php';
use \Firebase\JWT\JWT;

// Your secret key to sign the JWT token
// $mySecretKey coming from key.php

// Assuming you have a function to validate user credentials
function validate_user_credentials($username, $password) {
    // Your logic to validate the user credentials (e.g., query the database)
    // Return true if the credentials are valid, false otherwise
    // For demonstration purposes, let's assume the credentials are valid
    return true;
}

// Assuming you have a function to get user details from the database
function get_user_details($username) {
    // Your logic to get user details from the database based on the username
    // For demonstration purposes, let's return a hardcoded user object
    return [
        'username' => $username,
        // You can include additional user information here (e.g., user ID, roles, etc.)
    ];
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the username and password from the request
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate user credentials
    if (validate_user_credentials($username, $password)) {
        // Generate JWT token
        $user_details = get_user_details($username);
        $token_payload = [
            'username' => $user_details['username'],
            'user_id' => 123,
            'exp' => time() + (60 * 60) // Token expiration set to 1 hour from now
        ];
        $algorithm = 'HS256';
        $mySecretKey = "aea2f9f120485ca76fb3acb6b69e3c31463f4779";
        $jwt_token = JWT::encode($token_payload, $mySecretKey, $algorithm);

        // Return the JWT token in the response
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode(['token' => $jwt_token]);
        exit;
    } else {
        // If the credentials are invalid, return a 401 Unauthorized response
        http_response_code(401);
        echo "Invalid username or password";
        exit;
    }
} else {
    // If the request method is not POST, return a 405 Method Not Allowed response
    http_response_code(405);
    echo "Method Not Allowed";
    exit;
}








?>