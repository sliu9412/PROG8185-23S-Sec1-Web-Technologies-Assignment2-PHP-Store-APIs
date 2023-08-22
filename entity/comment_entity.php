<?php
class Comment
{
    public int $id;
    public int $product_id;
    public int $user_id;
    public string $comment;
    public string $date;
    public int $rating;

    public function __construct(
        $id = 0,
        $product_id = 0,
        $user_id = 0,
        $comment = "",
        $date = date("Y-m-d H:i:s"), $rating = 0)
    {
        $this->id = $id;
        $this->product_id = $product_id;
        $this->user_id = $user_id;
        $this->comment = $comment;
        $this->date = $date;
        $this->rating = $rating;
    }

}

class CommentImages
{
    public int $id;
    public int $comment_id;
    public string $src;
    public function __construct(
        $id = 0,
        $comment_id = 0,
        $src = ""

    ) {
        $this->id = $id;
        $this->comment_id = $comment_id;
        $this->src = $src;

    }
}

?>