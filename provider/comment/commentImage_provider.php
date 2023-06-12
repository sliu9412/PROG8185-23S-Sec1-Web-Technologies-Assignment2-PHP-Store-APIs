<?php 
require_once("../../utils/connect_db.php");
require_once("../../entity/comment_entity.php");


function getCommentImages($comment_id){
    $table_name = "comment_images";
    $query = $GLOBALS['db']->prepare("SELECT * FROM $table_name where comment_id= :comment_id");
    $query->bindValue(":comment_id", $comment_id);
    $query->execute();
    $query_arr = $query->fetchAll(PDO::FETCH_ASSOC);

    if (count($query_arr) > 0) {
        $commentImages_arr = array();
        
        foreach($query_arr as $data){            
            $commentImage = new CommentImages();
            $commentImage->id = intval($data['id']);
            $commentImage->comment_id = $data['comment_id'];
            $commentImage->src = $data['src'];

            array_push($commentImages_arr, $commentImage);
        }

        return $commentImages_arr;
    }
    return throw new Exception("Comment '$comment_id' not found", 404);
}


?>