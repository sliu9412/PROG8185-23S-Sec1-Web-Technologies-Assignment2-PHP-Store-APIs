<?php
require_once("json_response.php");
require_once("settings.php");

function ConnectDB($host, $dbname, $port, $username, $password)
{
    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $username, $password);
        return $db;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        JsonResponse("ConnectDB Failed, $error_message", 500);
    }
}

$GLOBALS["db"] = ConnectDB(
    "161.35.140.236",
    "ecommerce",
    6033,
    "root",
    "rootpass"
);
