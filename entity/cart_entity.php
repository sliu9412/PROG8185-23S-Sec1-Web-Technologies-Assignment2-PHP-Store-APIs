<?php
class CartItem {
    public int $user_id;
    public int $product_id;
    public int $quantity;
}

class PurchasedOrder {
    public int $order_id;
    public string $trx_id;
    public int $product_id;
    public int $user_id;
    public int $quantity;
    public float $price;
    public float $shipping_price;
    public DateTime $date;
    public float $total_price;
    public float $total_taxes; 
}
?>
