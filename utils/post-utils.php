<?php
require('initialize.php');
class PostUtils{
    static function total_posts(){
        $db=DatabaseUtils::get_connection();
        $stmt = $db->prepare("SELECT count(*) from posts;");
        $result=$stmt->execute();
        return $result[0];
    }
    static function posts(){
        $db=DatabaseUtils::get_connection();
        $stmt = $db->prepare("SELECT * from posts;");
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    static function add_like($post_id){
        $db=DatabaseUtils::get_connection();
        echo $post_id;
        echo "<script>console.log(2)</script>";
        try{
            //fetching post likes
            $stmt = $db->prepare("SELECT likes from posts WHERE post_id=:post_id;");
            $stmt->execute(array(':post_id'=>$post_id));
            $post_likes=$stmt->fetch(PDO::FETCH_ASSOC);
            //incrementing post likes
            ++$post_likes['likes'];
            //writing back to database
            $stmt = $db->prepare("UPDATE posts SET likes=:post_likes WHERE post_id=:post_id;");
            $stmt->execute(array(':post_id'=>$post_id
            ,':post_likes'=>$post_likes['likes']));
        }catch(PDOException $e)
        {
            echo $stmt . "<br>" . $e->getMessage();
        }
    }
}
?>