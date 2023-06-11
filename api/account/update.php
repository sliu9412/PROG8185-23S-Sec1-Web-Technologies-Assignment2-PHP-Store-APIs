<?php
require_once("../../provider/account/account_provider.php");

function UpdateAccount(...$args)
{
    // get user from JWT session
    $user = $args[$GLOBALS["session"]];
    // retrieves raw json data
    $inputData = file_get_contents('php://input');
    $putData = json_decode($inputData, true);
    // retrieves and validate JWT
    header("Content-Type: JSON");
    $email = $putData['email'];
    $username = $putData['username'];
    $password = $putData['password'];
    $province = $putData['province'];
    $city = $putData['city'];
    $zipcode = $putData['zipcode'];

    if ($username  && $password && $province && $city && $zipcode && $email) {
        $updatedAccount = updateUserAccount(
            $user->id,
            $email,
            $username,
            $password,
            $province,
            $city,
            $zipcode
        );
        JsonResponse("Account Successfully Updated", [
            "uid" => $updatedAccount->id,
            "username" => $updatedAccount->username,
            "province" => $updatedAccount->province,
            "city" => $updatedAccount->city,
            "zipcode" => $updatedAccount->zipcode,
            "email" => $updatedAccount->email
        ]);
    }
    else {
        // If info are not completed, update operation is not allowed
        throw new Exception("Info is not completed, cannot update account", 400);
    }
}

ApiWrapper("UpdateAccount", "PUT");
