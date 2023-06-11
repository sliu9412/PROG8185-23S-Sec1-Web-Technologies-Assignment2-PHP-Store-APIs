<?php
require_once("../../provider/product/cart_provider.php");
require_once("../../api/dto/cart_dto.php");
require_once("../../entity/product_entity.php");

function getShoppingCartByUserID($userID) {
    $userDBCart = getCartByUserID($userID);
    $userCart = new UserCart();
    foreach($userDBCart as $dbCartItem) {
        $cartItem = new Item();
        $cartItem->product_data = new Product(
            $dbCartItem->id,
            $dbCartItem->name,
            $dbCartItem->price,
            $dbCartItem->img,
            $dbCartItem->shipping_cost,
            $dbCartItem->description
        );
        $cartItem->product_total_price = ($dbCartItem->price * $dbCartItem->quantity);
        $cartItem->product_quantity = $dbCartItem->quantity;
        $userCart->addItem($cartItem);
        $userCart->total_price += $cartItem->product_total_price;
        $userCart->total_quantity += $dbCartItem->quantity;
    }
    return $userCart;
}
?>