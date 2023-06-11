<?php
require_once("../../provider/product/cart_provider.php");

class UserCart {
    public $cart;
    public function __construct() {
        $this->cart = array();
    }
}

function GetCartInfo(...$args) {
    // retrieves raw json data
    header("Content-Type: JSON");
    // get user from JWT session
    $user = $args[$GLOBALS["session"]];

    $userCart = getCartByUserID($user->id);
    JsonResponse("Shopping Cart Successful Updated", [
        "cart" => $userCart
    ]);
}

ApiWrapper("GetCartInfo", "GET");