<?php
// Import json web token
require_once("../../vendor/autoload.php");

use Firebase\JWT\JWT;
require_once("../../provider/account/account_provider.php");

function CreateUser()
{
    header("Content-Type: JSON");
    $username = $_POST['username'];
    $password = $_POST['password'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $zipcode = $_POST['zipcode'];
    $email = $_POST['email'];
    
    $createdAccount = registerAccount($username, $password, $province, $city, $zipcode, $email);

    $jwt = JWT::encode([
        "email" => $createdAccount->email,
    ], $GLOBALS["settings"]["jwt_key"], $GLOBALS["settings"]["jwt_alg"]);
    
    JsonResponse("Create Account Successfully", [
        "uid" => $createdAccount->id,
        "username" => $createdAccount->username,
        "jwt" => $jwt
    ]);
}

ApiWrapper("CreateUser");
