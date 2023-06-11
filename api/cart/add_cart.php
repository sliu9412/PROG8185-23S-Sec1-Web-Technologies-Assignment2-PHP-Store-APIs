<?php
require_once("../../provider/product/product_provider.php");
require_once("../../provider/product/cart_provider.php");

function AddProductToCart(...$args)
{
    // retrieves raw json data
    $inputData = file_get_contents('php://input');
    $cartData = json_decode($inputData, true);
    header("Content-Type: JSON");
    // get user from JWT session
    $user = $args[$GLOBALS["session"]];
    if (isset($cartData["product_id"]) 
        && isset($cartData["quantity"])
        && is_numeric($cartData['quantity'])
        && intval($cartData['quantity']) >= 0) {
        $numberQty = intval($cartData['quantity']);
        $product = getProductsByID($cartData["product_id"]);
        $affectedRow = createOrUpdateProductCart(
            $user->id, 
            $product->id, 
            $numberQty
        );
        $response = "created";
        if ($numberQty > 0 
            && ($affectedRow == 2 || $affectedRow == 0)) {
            $response = "updated";
        } else if ($numberQty == 0) {
            if ($affectedRow == 1) {
                $response = "deleted";
            }
            else {
                $response = "none";
            }
        }
        JsonResponse("Shopping Cart Successful Updated", [
            "action" => $response
        ]);
    } else {
        throw new Exception("Invalid request", 500);
    }
    
}

ApiWrapper("AddProductToCart", "POST");
