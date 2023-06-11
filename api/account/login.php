<?php
require_once("../../vendor/autoload.php");

use Firebase\JWT\JWT;

require_once("../../provider/account/account_provider.php");

function LoginAccount()
{
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $authenticatedUser = authenticateUser($_POST["email"], $_POST["password"]);
        // pass authentication
        $jwt = JWT::encode([
            "uid" => $authenticatedUser->id,
        ], $GLOBALS["settings"]["jwt_key"], $GLOBALS["settings"]["jwt_alg"]);
        JsonResponse("Login successfully", [
            "uid" => $authenticatedUser->id,
            "username" => $authenticatedUser->username,
            "jwt" => $jwt,
        ]);
    } else {
        throw new Exception("Invalid request", 500);
    }
}

ApiWrapper("LoginAccount", "POST", false);
