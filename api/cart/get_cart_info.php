<?php
require_once("../../service/cart_service.php");

function GetCartInfo(...$args) {
    // retrieves raw json data
    header("Content-Type: JSON");
    // get user from JWT session
    $user = $args[$GLOBALS["session"]];
    $userCart = getShoppingCartByUserID($user->id);
    JsonResponse("Shopping Cart Successful Updated", [
        "cart" => $userCart
    ]);
}

ApiWrapper("GetCartInfo", "GET");