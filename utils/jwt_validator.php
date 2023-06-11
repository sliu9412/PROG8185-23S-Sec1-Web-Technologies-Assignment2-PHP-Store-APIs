<?php
require_once("../../vendor/autoload.php");

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// validate and decode Token and returns user ID from it
function JwtValidator($token)
{
    try {
        $payload = (array)JWT::decode($token, new Key($GLOBALS["settings"]["jwt_key"], $GLOBALS["settings"]["jwt_alg"]));
        return $payload["uid"];
    } catch (Exception $e) {
        throw new Exception("Invalid JWT session Token", 401);
    }
}

function getJWTFromHeaders() {
    // Check if the Authorization header exists
    if (isset($_SERVER['HTTP_AUTHORIZATION']) || ($headers = getallheaders()) && isset($headers['Authorization'])) {
        $authorizationHeader = isset($_SERVER['HTTP_AUTHORIZATION']) ? $_SERVER['HTTP_AUTHORIZATION'] : $headers['Authorization'];
        // Split the header value to separate the scheme and token
        $headerParts = explode(' ', $authorizationHeader);
    
        // Check if the header has two parts and the scheme is "Bearer"
        if (count($headerParts) === 2 && $headerParts[0] === 'Bearer') {
            $jwtToken = $headerParts[1];
    
            // Use the JWT token as needed
            return $jwtToken;
        } else {
            // Handle the case when the scheme is not "Bearer"
            throw new Exception("Invalid Authorization header scheme.", 401);
        }
    } else {
        // Handle the case when the Authorization header is not provided
        throw new Exception("Authorization header is missing.");
    }
}
