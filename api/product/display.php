<?php
require_once("../../provider/product/product_provider.php");

function ProductDisplay()
{
    header("Content-Type: JSON");
    $response = getAllProductsData();
    if($response){
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
    else{
        throw new Exception("There are no products", 204);
    }
}

ApiWrapper("ProductDisplay", "GET");
?>