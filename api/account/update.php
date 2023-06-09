<?php
require_once("../../utils/connect_db.php");
require_once("../../utils/jwt_validator.php");

function UpdateAccount()
{
    $table_name = "userinfo";
    $username = $_POST['username'];
    $password = $_POST['password'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $zipcode = $_POST['zipcode'];
    $email = $_POST['email'];
    $uid = $_POST['uid'];
    if ($username  && $password && $province && $city && $zipcode && $email && $uid) {
        $query = $GLOBALS["db"]->prepare("SELECT email FROM $table_name WHERE id = :id");
        $query->bindValue(':id', $uid);
        $query->execute();
        // find previous email to compare jwt firstly
        $previous_email = $query->fetchALL(PDO::FETCH_ASSOC)[0]["email"];
        if (JwtValidator($_POST["jwt"], $previous_email)) {
            $query = $GLOBALS["db"]->prepare("UPDATE $table_name SET username=:username, password=:password, province = :province, city = :city, zipcode = :zipcode, email = :email WHERE id = :id AND email = :premail");
            $query->bindValue(":username", $username);
            $query->bindValue(":password", password_hash($password, PASSWORD_DEFAULT));
            $query->bindValue(":province", $province);
            $query->bindValue(":city", $city);
            $query->bindValue(":zipcode", $zipcode);
            $query->bindValue(":email", $email);
            $query->bindValue(":id", $uid);
            $query->bindValue(":premail", $previous_email);
            $query->execute();
            JsonResponse("Update Account Successfully");
        } else {
            throw new Exception("Invalid token", 400);
        }
    } else {
        // If info are not completed, update operation is not allowed
        throw new Exception("Info is not completed, cannot update account", 400);
    }
}

ApiWrapper("UpdateAccount");
