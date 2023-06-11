<?php
require_once("../../utils/connect_db.php");
require_once("../../entity/user_entity.php");

function registerAccount(
    $username, 
    $password,
    $province,
    $city,
    $zipcode,
    $email) {
    // db table name
    $table_name = "userinfo";
    if ($username  && $password && $province && $city && $zipcode && $email) {
        $check = checkDuplicatedAccount($email);
        if (checkDuplicatedAccount($email)) {
            throw new Exception("User email '$email' already exists", 409);
        }
        $query = $GLOBALS["db"]->prepare("INSERT INTO $table_name (username, password, province, city, zipcode, email) VALUES(:username, :password, :province, :city, :zipcode, :email)");
        $query->bindValue(":username", $username);
        $query->bindValue(":password", password_hash($password, PASSWORD_DEFAULT));
        $query->bindValue(":province", $province);
        $query->bindValue(":city", $city);
        $query->bindValue(":zipcode", $zipcode);
        $query->bindValue(":email", $email);
        $query->execute();
        $lastInsertedId = $GLOBALS["db"]->lastInsertId();
        return getUserByID($lastInsertedId);
    } else {
        throw new Exception("User needs to fill all the fields", 400);
    }
}

function authenticateUser($email, $password) {
    $table_name = "userinfo";
    $actualUser = getUserByEmail($email, true);
    // account is existed
    $password_hash = $actualUser->password;
    if (password_verify($password, $password_hash)) {
        // pass authentication
        return $actualUser;
    } else {
        throw new Exception("Email or password are not valid", 401);
    }
}

function updateUserAccount(
    $userID,
    $email,
    $username, 
    $password,
    $province,
    $city,
    $zipcode) {
    // db table name
    $table_name = "userinfo";
    if ($username  && $password && $province && $city && $zipcode && $email) {
        $actualUserData = getUserByID($userID);
        $query = $GLOBALS["db"]->prepare("UPDATE $table_name SET username=:username, password=:password, province = :province, city = :city, zipcode = :zipcode, email = :email WHERE id = :id");
        $query->bindValue(":username", $username);
        $query->bindValue(":password", password_hash($password, PASSWORD_DEFAULT));
        $query->bindValue(":province", $province);
        $query->bindValue(":city", $city);
        $query->bindValue(":zipcode", $zipcode);
        $query->bindValue(":email", $email);
        $query->bindValue(":id", $userID);
        $query->execute();
        return getUserByID($actualUserData->id);
    } else {
        throw new Exception("User needs to fill all the fields to be updated", 400);
    }
}

function checkDuplicatedAccount($email) {
    $table_name = "userinfo";
    $email = $_POST["email"];
    $query = $GLOBALS["db"]->prepare("SELECT COUNT(email) as count FROM $table_name WHERE email = :email");
    $query->bindValue(":email", $email);
    $query->execute();
    $count = $query->fetch()["count"];
    return intval($count);
}

function getUserByID($id) {
    $table_name = "userinfo";
    $query = $GLOBALS["db"]->prepare("SELECT * FROM $table_name WHERE id = :id");
    $query->bindValue(":id", $id);
    $query->execute();
    $query_arr = $query->fetchAll(PDO::FETCH_ASSOC);
    if (count($query_arr) > 0) {
        $createdAccount = new UserAccount();
        $createdAccount->id = intval($query_arr[0]["id"]);
        $createdAccount->username = $query_arr[0]["username"];
        $createdAccount->password = $query_arr[0]["password"];
        $createdAccount->province = $query_arr[0]["province"];
        $createdAccount->city = $query_arr[0]["city"];
        $createdAccount->zipcode = $query_arr[0]["zipcode"];
        $createdAccount->email = $query_arr[0]["email"];
        return $createdAccount;
    }
    throw new Exception("User ID '$id' does not exists", 404);
}

function getUserByEmail($email, $forLogin = true) {
    $table_name = "userinfo";
    $query = $GLOBALS["db"]->prepare("SELECT * FROM $table_name WHERE email = :email");
    $query->bindValue(":email", $email);
    $query->execute();
    $query_arr = $query->fetchAll(PDO::FETCH_ASSOC);
    if (count($query_arr) > 0) {
        $createdAccount = new UserAccount();
        $createdAccount->id = intval($query_arr[0]["id"]);
        $createdAccount->username = $query_arr[0]["username"];
        $createdAccount->password = $query_arr[0]["password"];
        $createdAccount->province = $query_arr[0]["province"];
        $createdAccount->city = $query_arr[0]["city"];
        $createdAccount->zipcode = $query_arr[0]["zipcode"];
        $createdAccount->email = $query_arr[0]["email"];
        return $createdAccount;
    }
    $errorCode = 404;
    $errorMessage = "User not found";
    if ($forLogin) {
        $errorCode = 401;
        $errorMessage = "Email or password are not valid";
    }
    throw new Exception($errorMessage, $errorCode);
}
?>