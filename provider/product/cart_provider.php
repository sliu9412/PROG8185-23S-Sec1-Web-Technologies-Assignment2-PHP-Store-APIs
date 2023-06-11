<?php
require_once("../../utils/connect_db.php");
require_once("../../entity/product_entity.php");
require_once("../../entity/cart_entity.php");

function getCartByUserID($user_id) {
    $table_name = "user_cart";
    $sql = "
        SELECT uc.quantity, p.* 
        FROM product p INNER JOIN user_cart uc 
        ON p.id = uc.product_id AND uc.user_id = :user_id; 
    ";
    $query = $GLOBALS["db"]->prepare($sql);
    $query->bindValue(":user_id", $user_id);
    $query->execute();
    $cartItems = array();
    if($query){
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $product = new ProductCart();
            $product->quantity = intval($row['quantity']);
            $product->id = intval($row['id']);
            $product->name = $row['name'];
            $product->price = floatval($row['price']);
            $product->img = $row['img'];
            $product->shipping_cost = floatval($row['shipping_cost']);
            $product->description = $row['description'];
            $cartItems[] = $product;
        }
    }
    return $cartItems;
}

function createOrUpdateProductCart($user_id, $product_id, $quantity) {
    $table = "user_cart";
    $strQuery = "
        INSERT INTO $table (user_id, product_id, quantity)
        VALUES (:user_id, :product_id, :quantity)
        ON DUPLICATE KEY UPDATE quantity = :quantity;
    ";
    if ($quantity == 0) {
        $strQuery = "
            DELETE FROM $table 
            WHERE user_id = :user_id AND product_id = :product_id;
        ";
    }
    $query = $GLOBALS["db"]->prepare($strQuery);
    $query->bindValue(":user_id", $user_id);
    $query->bindValue(":product_id", $product_id);
    if ($quantity > 0) {
        $query->bindValue(":quantity", $quantity);
    }
    $query->execute();
    $rowCount = $query->rowCount();
    return $rowCount;
}
?>