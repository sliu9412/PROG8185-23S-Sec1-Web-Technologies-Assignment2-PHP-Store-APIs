<?php
require_once("../../provider/comment/comment_provider.php");

function CommentDisplayByUser(...$args)
{
    header("Content-Type: JSON");
    $user = $args[$GLOBALS["session"]];


    $response = getCommentForTheUser($user->id);
    if($response){
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
    else{
        throw new Exception("There are no comments", 204);
    }
}

ApiWrapper("CommentDisplayByUser", "GET");
?>