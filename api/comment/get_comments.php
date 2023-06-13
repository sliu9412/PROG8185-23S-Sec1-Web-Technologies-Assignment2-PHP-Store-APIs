<?php
require_once("../../provider/comment/comment_provider.php");

function CommentDisplayByProduct(...$args)
{
    header("Content-Type: JSON");

    $product_id = htmlspecialchars($_GET["product_id"]);

    $response = getCommentForTheProduct($product_id);
    if($response){
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
    else{
        throw new Exception("There are no comments", 204);
    }
}

ApiWrapper("CommentDisplayByProduct", "GET");
?>