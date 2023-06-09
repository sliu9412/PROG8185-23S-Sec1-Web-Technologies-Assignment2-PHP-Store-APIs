<?php
require_once("../../utils/connect_db.php");
require_once("../../utils/jwt_validator.php");

function GetUserInfo()
{
    if (isset($_POST["uid"])) {
        $table_name = "userinfo";
        $uid  = $_POST["uid"];
        $query = $GLOBALS["db"]->prepare("SELECT * FROM $table_name WHERE id = :id");
        $query->bindValue(':id', $uid);
        $query->execute();
        $user_info = $query->fetchAll(PDO::FETCH_ASSOC)[0];
        $email = $user_info["email"];
        // Only valid token can get user information
        if (JwtValidator($_POST["jwt"], $email)) {
            JsonResponse("Get user information successfully", [
                "uid" => $uid,
                "username" => $user_info["username"],
                "provinces" => $user_info["province"],
                "city" => $user_info["city"],
                "email" => $user_info["email"],
            ]);
        } else {
            throw new Exception("Invalid token", 400);
        }
    } else {
        throw new Exception("Cannot get user information without uid");
    }
}

ApiWrapper("GetUserInfo");
