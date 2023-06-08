<?php
require("../../utils/connect_db.php");

// db table name
function CheckDuplicateMail()
{
    if (isset($_POST["email"])) {
        $table_name = "userinfo";
        $email = $_POST["email"];
        $query = $GLOBALS["db"]->prepare("SELECT COUNT(email) as count FROM $table_name WHERE email = :email");
        $query->bindValue(":email", $email);
        $query->execute();
        $count = $query->fetch()["count"];
        if (intval($count) == 0) {
            JsonResponse(true);
        } else {
            JsonResponse(false);
        }
    } else {
        throw new Exception("Invalid request", 400);
    }
}

ApiWrapper("CheckDuplicateMail");
