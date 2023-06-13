<?php
require_once("../../utils/connect_db.php");
require_once("../../entity/cart_entity.php");
require_once("../../entity/order_entity.php");

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

function getOrderHistory(int $user_id): array {
    $sql = '
        SELECT trx_id
            , sum(quantity) as total_quantity
            , sum(total_price) as total_price
            , sum(total_taxes) as total_taxes
            , sum(shipping_price) as total_shipping
            , max(date) order_date
        FROM purchased_order 
        WHERE user_id = :user_id
        GROUP BY trx_id;
    ';
    $query = $GLOBALS["db"]->prepare($sql);
    $query->bindParam(':user_id', $user_id);
    $query->execute();
    $purchaseHistory = array();
    if($query){
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $purchased = new PurchaseHistory();
            $purchased->trx_id = $row['trx_id'];
            $purchased->total_quantity = intval($row['total_quantity']);
            $purchased->total_price = floatval($row['total_price']);
            $purchased->total_taxes = floatval($row['total_taxes']);
            $purchased->total_shipping = floatval($row['total_shipping']);
            $purchased->order_date = $row['order_date'];
            $purchaseHistory[] = $purchased;
        }
    }
    return $purchaseHistory;
}

?>