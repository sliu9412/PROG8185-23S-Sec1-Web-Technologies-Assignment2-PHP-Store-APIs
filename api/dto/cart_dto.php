<?php
require_once("../../entity/product_entity.php");

class UserCart {
    public float $total_price;
    public float $total_shipping_cost;
    public int $total_quantity;
    public float $total_taxes;
    public $cart_items;
    public function __construct() {
        $this->cart_items = array();
        $this->total_price = 0;
        $this->total_quantity = 0;
        $this->total_shipping_cost = 0;
        $this->total_taxes = 0;
    }

    public function addItem(Item $item) {
        $this->cart_items[] = $item;
    }
}

class Item {
    public float $product_total_price;
    public int $product_quantity;
    public float $product_taxes;
    public Product $product_data;
}
?>