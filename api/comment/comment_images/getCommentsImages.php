<?php
require_once("../../provider/comment/comment_provider.php");

function CommentImagesDisplay(...$args)
{
    header("Content-Type: JSON");
    

    $response = getCommentImages($comment_id);
    if($response){
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
    else{
        throw new Exception("There are no comments", 204);
    }
}

ApiWrapper("CommentImagesDisplay", "GET");
?>