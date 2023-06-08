<?php
// Import json web token
require_once("../../vendor/autoload.php");

use Firebase\JWT\JWT;
// connect the database
require_once("../../utils/connect_db.php");

function CreateUser()
{
    // db table name
    $table_name = "userinfo";
    $username = $_POST['username'];
    $password = $_POST['password'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $zipcode = $_POST['zipcode'];
    $email = $_POST['email'];
    if ($username  && $password && $province && $city && $zipcode && $email) {
        $query = $GLOBALS["db"]->prepare("INSERT INTO $table_name (username, password, province, city, zipcode, email) VALUES(:username, :password, :province, :city, :zipcode, :email)");
        $query->bindValue(":username", $username);
        $query->bindValue(":password", password_hash($password, PASSWORD_DEFAULT));
        $query->bindValue(":province", $province);
        $query->bindValue(":city", $city);
        $query->bindValue(":zipcode", $zipcode);
        $query->bindValue(":email", $email);
        $query->execute();
        $query = $GLOBALS["db"]->prepare("SELECT * FROM $table_name WHERE id = last_insert_id()");
        $query->execute();
        $jwt = JWT::encode([
            "email" => $email,
        ], $GLOBALS["settings"]["jwt_key"], $GLOBALS["settings"]["jwt_alg"]);
        $query_arr = $query->fetchAll(PDO::FETCH_ASSOC);
        JsonResponse("Create Account Successfully", [
            "uid" => $query_arr[0]["id"],
            "username" => $query_arr[0]["username"],
            "jwt" => $jwt
        ]);
    } else {
        throw new Exception("User needs to fill all the fields", 400);
    }
}

ApiWrapper("CreateUser");
