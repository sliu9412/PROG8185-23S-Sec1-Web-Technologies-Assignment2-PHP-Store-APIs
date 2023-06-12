<?php 
require_once("../../utils/connect_db.php");
require_once("../../entity/comment_entity.php");


function getCommentForTheProduct($product_id){
    $table_name = "comment";
    $query = $GLOBALS['db']->prepare("SELECT * FROM $table_name where product_id= :product_id");
    $query->bindValue(":product_id", $product_id);
    $query->execute();
    $query_arr = $query->fetchAll(PDO::FETCH_ASSOC);

    if (count($query_arr) > 0) {
        $comment_arr = array();
        
        foreach($query_arr as $data){            
            $comment = new Comment();
            $comment->id = intval($data['id']);
            $comment->product_id = $data['product_id'];
            $comment->user_id = $data['user_id'];
            $comment->comment = $data['comment'];
            $comment->date = $data['date'];
            $comment->date = $data['rating'];


            array_push($comment_arr, $comment);
        }




        return $comment_arr;
    }
    return throw new Exception("Product '$product_id' not found", 404);
}

function getCommentForTheUser($user_id){
    $table_name = "comment";
    $query = $GLOBALS['db']->prepare("SELECT * FROM $table_name where user_id= :user_id");
    $query->bindValue(":user_id", $user_id);
    $query->execute();
    $query_arr = $query->fetchAll(PDO::FETCH_ASSOC);

    if (count($query_arr) > 0) {
        $comment_arr = array();
        
        foreach($query_arr as $data){            
            $comment = new Comment();
            $comment->id = intval($data['id']);
            $comment->product_id = $data['product_id'];
            $comment->user_id = $data['user_id'];
            $comment->comment = $data['comment'];
            $comment->date = $data['date'];
            $comment->date = $data['rating'];


            array_push($comment_arr, $comment);
        }




        return $comment_arr;
    }
    return throw new Exception("User '$user_id' not found", 404);
}
?>