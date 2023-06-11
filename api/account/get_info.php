<?php
require_once("../../utils/json_response.php");

function GetUserInfo(...$args)
{
    header("Content-Type: JSON");
    // get user from JWT session
    $user = $args[$GLOBALS["session"]];
    JsonResponse("Get user information successfully", [
        "uid" => $user->id,
        "username" => $user->username,
        "provinces" => $user->province,
        "city" => $user->city,
        "email" => $user->email,
    ]);
}

ApiWrapper("GetUserInfo", "GET");
