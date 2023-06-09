<?php
require_once("../../vendor/autoload.php");

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// validate token with email
function JwtValidator($token, $email)
{
    try {
        $payload = (array)JWT::decode($token, new Key($GLOBALS["settings"]["jwt_key"], $GLOBALS["settings"]["jwt_alg"]));
        if ($email === $payload["email"]) {
            return true;
        }
        return false;
    } catch (Exception $e) {
        return false;
    }
}
