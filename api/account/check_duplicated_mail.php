<?php
require("../../provider/account/account_provider.php");

// db table name
function CheckDuplicateMail()
{
    if (isset($_POST["email"])) {
        $email = $_POST["email"];
        $count = checkDuplicatedAccount($email);
        error_log("email $count");
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
