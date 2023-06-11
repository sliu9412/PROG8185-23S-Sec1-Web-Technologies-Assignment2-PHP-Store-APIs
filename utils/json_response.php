<?php
require_once("jwt_validator.php");
require_once("../../provider/account/account_provider.php");

header("Content-Type: application/json");
header("Access-Control-Allow-Origin:*");

// generate JSON format response automatically
function JsonResponse($message = "", $data = false, $status = 200)
{
    $res = $data ? json_encode(
        [
            "status" => $status,
            "message" => $message,
            "data" => $data,
        ]
    ) : json_encode(
        [
            "status" => $status,
            "message" => $message,
        ]
    );
    print_r($res);
}

// Wrap the code of API, to handle Exceptions
function ApiWrapper(callable $func, $request_method = "POST", $jwt_validation = true, ...$args)
{
    try {
        if ($_SERVER['REQUEST_METHOD'] == $request_method) {
            if ($jwt_validation) {
                $authorizationHeader = getJWTFromHeaders();
                $tokenID = JwtValidator($authorizationHeader);
                $user = getUserByID($tokenID);
                $args[$GLOBALS["session"]] = $user;
            }
            return $func(...$args);
        } else {
            JsonResponse("Error, Request Method should be $request_method", status: 400);
        }
    } catch (\Exception $e) {
        $error_message = $e->getMessage();
        JsonResponse("Request Error, $error_message", status: $e->getCode());
    }
}
