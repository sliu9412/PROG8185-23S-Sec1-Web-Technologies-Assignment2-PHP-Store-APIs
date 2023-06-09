<?php
require_once("../../vendor/autoload.php");

use Firebase\JWT\JWT;

require_once("../../utils/connect_db.php");

function LoginAccount()
{
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $table_name = "userinfo";
        $email = $_POST["email"];
        $password = $_POST["password"];
        $query = $GLOBALS["db"]->prepare("SELECT * FROM $table_name WHERE email=:email");
        $query->bindValue(':email', $email);
        $query->execute();
        $res = $query->fetchAll();
        if (count($res) == 1) {
            // account is existed
            $password_hash = $res[0]["password"];
            if (password_verify($password, $password_hash)) {
                // pass authentication
                $jwt = JWT::encode([
                    "email" => $res[0]["email"],
                ], $GLOBALS["settings"]["jwt_key"], $GLOBALS["settings"]["jwt_alg"]);
                JsonResponse("Login successfully", [
                    "uid" => $res[0]["id"],
                    "username" => $res[0]["username"],
                    "jwt" => $jwt,
                ]);
            } else {
                throw new Exception("Email and password are not the matched", 400);
            }
        } else {
            throw new Exception("The Email is not exist", 400);
        }
    } else {
        throw new Exception("Invalid Request", 400);
    }
}

ApiWrapper("LoginAccount");
