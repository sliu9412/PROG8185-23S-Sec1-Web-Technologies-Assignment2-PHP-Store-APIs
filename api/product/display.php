<?php
require_once("../../utils/connect_db.php");

function productDisplay()
{
    $table_name = "product";

    if($GLOBALS["db"]){
        $sql = "SELECT * from $table_name";
        $result = $GLOBALS["db"]->query($sql);
        
        if($result){
            header("Content-Type: JSON");
            $i=0;

            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                $response[$i]['id']=$row['id'];
                $response[$i]['name']=$row['name'];
                $response[$i]['price']=$row['price'];
                $response[$i]['img']=$row['img'];
                $response[$i]['shipping_cost']=$row['shipping_cost'];
                $response[$i]['description']=$row['description'];
                $i++;
            }
            echo json_encode($response,JSON_PRETTY_PRINT);
        }
    }
    else{
        echo "Databse Connection Failed";
    }
}

ApiWrapper("productDisplay");
?>