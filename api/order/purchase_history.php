<?php
require_once("../../provider/order/order_provider.php");

function GetPurchasedOrderHistory(...$args) {
    // retrieves raw json data
    header("Content-Type: JSON");
    // get user from JWT session
    $user = $args[$GLOBALS["session"]];
    $orderHistory = getOrderHistory($user->id);
    JsonResponse("User Purchased Orders History", [
        "cart" => $orderHistory
    ]);
}

ApiWrapper("GetPurchasedOrderHistory", "GET");