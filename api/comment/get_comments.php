<?php
require_once("../../provider/comment/commentImage_provider.php");

function CommentDisplayByProduct(...$args)
{
    header("Content-Type: JSON");
    $response = getCommentForTheProduct($product_id);
    if($response){
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
    else{
        throw new Exception("There are no comments", 204);
    }
}

ApiWrapper("CommentDisplayByProduct", "GET");
