<?php
class Product {
    public int $id;
    public string $name;
    public float $price;
    public string $img;
    public float $shipping_cost;
    public string $description;

    public function __construct(
        $id = 0, 
        $name = "", 
        $price = 0.0, 
        $img = "", 
        $shipping_cost = 0.0, 
        $description = ""
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->img = $img;
        $this->shipping_cost = $shipping_cost;
        $this->description = $description;
    }

}

class ProductCart extends Product {
    public $quantity;
}

?>
