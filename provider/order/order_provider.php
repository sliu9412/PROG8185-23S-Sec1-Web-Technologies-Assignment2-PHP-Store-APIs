<?php
require_once("../../utils/connect_db.php");
require_once("../../entity/cart_entity.php");

function purchaseCartOrder(array $purchasedOrder): int {
    $table_name = "purchased_order";
    $sql = "
        INSERT INTO $table_name (
            user_id,
            product_id,
            quantity,
            price,
            shipping_price,
            trx_id,
            total_taxes,
            total_price
        )
        VALUES (
            :user_id,
            :product_id,
            :quantity,
            :price,
            :shipping_price,
            :trx_id,
            :total_taxes,
            :total_price
        );
    ";
    $query = $GLOBALS["db"]->prepare($sql);
    $insertedIds = array();
    foreach ($purchasedOrder as $row) {
        try {
            $query->bindParam(':user_id', $row->user_id);
            $query->bindParam(':product_id', $row->product_id);
            $query->bindParam(':quantity', $row->quantity);
            $query->bindParam(':price', $row->price);
            $query->bindParam(':shipping_price', $row->shipping_price);
            $query->bindParam(':trx_id', $row->trx_id);
            $query->bindParam(':total_taxes', $row->total_taxes);
            $query->bindParam(':total_price', $row->total_price);
            $query->execute();
            $lastInsertedId = $GLOBALS["db"]->lastInsertId();
            $insertedIds[] = $lastInsertedId;
        }
        catch (\Exception $e) {
            // Rollback
            rollbackOrders($insertedIds);
            return 0;
        }
    }
    return 1;
}

function rollbackOrders(array $ordersId) {
    $table_name = "purchased_order";
    $sql = "DELETE FROM $table_name WHERE order_id = :order_id;";
    foreach ($ordersId as $order_id) {
        try {
            $query->bindParam(':order_id', $order_id);
            $query->execute();
        }
        catch(\Exception $e) {
            error_log("Error deleting '$order_id' from $table_name. $e");
        }
    }
}

?>