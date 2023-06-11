<?php
require_once("../../utils/jwt_validator.php");
require_once("../../provider/account/account_provider.php");

function GetUserInfo()
{
    header("Content-Type: JSON");
    $authorizationHeader = getJWTFromHeaders();
    $tokenEmail = JwtValidator($authorizationHeader);
    $user_info = getUserByEmail($tokenEmail);
    JsonResponse("Get user information successfully", [
        "uid" => $user_info->id,
        "username" => $user_info->username,
        "provinces" => $user_info->province,
        "city" => $user_info->city,
        "email" => $user_info->email,
    ]);
}

ApiWrapper("GetUserInfo", "GET");
