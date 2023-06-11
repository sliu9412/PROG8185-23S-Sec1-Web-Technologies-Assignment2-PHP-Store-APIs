<?php
require_once("../../service/cart_service.php");

function PurchaseCart(...$args) {
    header("Content-Type: JSON");
    // get user from JWT session
    $user = $args[$GLOBALS["session"]];
    $userCart = purchaseShoppingCart($user->id);
    JsonResponse("Shopping Cart Successful Updated", [
        "cart" => $userCart
    ]);
}

ApiWrapper("PurchaseCart", "POST");