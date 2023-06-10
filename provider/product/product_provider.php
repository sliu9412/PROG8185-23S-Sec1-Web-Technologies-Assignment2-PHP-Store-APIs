<?php
require_once("../../utils/connect_db.php");
require_once("../../entity/product_entity.php");

function getAllProductsData()
{
    $table_name = "product";
    $sql = "SELECT * from $table_name";
    $result = $GLOBALS["db"]->query($sql);
    
    if($result){
        $products = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $product = new Product();
            $product->id = $row['id'];
            $product->name = $row['name'];
            $product->price = $row['price'];
            $product->img = $row['img'];
            $product->shipping_cost = $row['shipping_cost'];
            $product->description = $row['description'];

            $products[] = $product;
        }
        return $products;
    }
    return false;
}
?>
