<?php
require_once("../../provider/product/cart_provider.php");
require_once("../../entity/product_entity.php");

class UserCart {
    public float $total_price;
    public int $total_quantity;
    public $cart_items;
    public function __construct() {
        $this->cart_items = array();
        $this->total_price = 0;
        $this->total_quantity = 0;
    }

    public function addItem(Item $item) {
        $this->cart_items[] = $item;
    }
}

class Item {
    public float $product_total_price;
    public int $product_quantity;
    public Product $product_data;
}

function GetCartInfo(...$args) {
    // retrieves raw json data
    header("Content-Type: JSON");
    // get user from JWT session
    $user = $args[$GLOBALS["session"]];

    $userDBCart = getCartByUserID($user->id);
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
    JsonResponse("Shopping Cart Successful Updated", [
        "cart" => $userCart
    ]);
}

ApiWrapper("GetCartInfo", "GET");