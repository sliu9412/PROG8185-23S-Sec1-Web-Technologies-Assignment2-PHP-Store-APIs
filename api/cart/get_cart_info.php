<?php
require_once("../../utils/jwt_validator.php");
require_once("../../provider/account/account_provider.php");
require_once("../../provider/product/cart_provider.php");

class UserCart {
    public $cart;
    public function __construct() {
        $this->cart = array();
    }
}

function GetCartInfo() {
    // retrieves raw json data
    header("Content-Type: JSON");
    // get user from JWT session
    $authorizationHeader = getJWTFromHeaders();
    $tokenID = JwtValidator($authorizationHeader);
    $user = getUserByID($tokenID);

    $userCart = getCartByUserID($user->id);
    JsonResponse("Shopping Cart Successful Updated", [
        "cart" => $userCart
    ]);
}

ApiWrapper("GetCartInfo", "GET");