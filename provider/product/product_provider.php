<?php
require_once("../../utils/connect_db.php");
require_once("../../entity/product_entity.php");

function getAllProductsData()
{
    $table_name = "product";
    $sql = "SELECT * from $table_name;";
    $result = $GLOBALS["db"]->query($sql);
    
    if($result){
        $products = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $product = new Product();
            $product->id = intval($row['id']);
            $product->name = $row['name'];
            $product->price = floatval($row['price']);
            $product->img = $row['img'];
            $product->shipping_cost = floatval($row['shipping_cost']);
            $product->description = $row['description'];

            $products[] = $product;
        }
        return $products;
    }
    return false;
}

function getProductsByID($product_id)
{
    $table_name = "product";
    $query = $GLOBALS["db"]->prepare("SELECT * from $table_name WHERE id = :product_id");
    $query->bindValue(":product_id", $product_id);
    $query->execute();
    $query_arr = $query->fetchAll(PDO::FETCH_ASSOC);
    if (count($query_arr) > 0) {
        $product = new Product();
        $product->id = intval($query_arr[0]['id']);
        $product->name = $query_arr[0]['name'];
        $product->price = floatval($query_arr[0]['price']);
        $product->img = $query_arr[0]['img'];
        $product->shipping_cost = floatval($query_arr[0]['shipping_cost']);
        $product->description = $query_arr[0]['description'];
        return $product;
    }
    return throw new Exception("Product '$product_id' not found", 404);
}
?>
