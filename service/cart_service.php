<?php
use Webpatser\Uuid\Uuid;
require_once("../../provider/product/cart_provider.php");
require_once("../../provider/order/order_provider.php");
require_once("../../api/dto/cart_dto.php");
require_once("../../entity/product_entity.php");

function purchaseShoppingCart($userID): array {
    $userDBCart = getShoppingCartByUserID($userID);
    $transactionID = Uuid::generate()->string;
    $purchasedOrder = array();
    foreach($userDBCart->cart_items as $cartItem) {
        $purchasedProduct = new PurchasedOrder();
        $purchasedProduct->trx_id = $transactionID;
        $purchasedProduct->product_id = $cartItem->product_data->id;
        $purchasedProduct->quantity = $cartItem->product_quantity;
        $purchasedProduct->price = $cartItem->product_data->price;
        $purchasedProduct->shipping_price = $cartItem->product_data->shipping_cost;
        $purchasedProduct->user_id = $userID;
        $purchasedProduct->total_price = $cartItem->product_total_price;
        $purchasedProduct->total_taxes = $cartItem->product_taxes;
        $purchasedOrder[] = $purchasedProduct;
    }
    $purchaseResponse = purchaseCartOrder($purchasedOrder);
    if ($purchaseResponse == 1) {
        deleteCartByUserID($userID);
    } else {
        throw new Exception("Purchase Order Process Error", 500);
    }
    return $purchasedOrder;
}

function getShoppingCartByUserID($userID): UserCart {
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
        $cartItem->product_taxes = ($GLOBALS["taxes"] * $dbCartItem->price);
        $userCart->addItem($cartItem);
        $userCart->total_price += $cartItem->product_total_price;
        $userCart->total_quantity += $dbCartItem->quantity;
        $userCart->total_shipping_cost += $dbCartItem->shipping_cost;
        $userCart->total_taxes += $cartItem->product_taxes;
    }
    return $userCart;
}
?>