<?php
require_once __DIR__ . '/database.php';
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
    static function get_post_detail($post_id){
        $db=DatabaseUtils::get_connection();
        $stmt = $db->prepare("SELECT * from posts WHERE post_id=:post_id;");
        $stmt->execute(array(':post_id'=>$post_id));
        if($stmt->rowCount()==0){
            OutputUtils::note_display_error('No Such Post found');
            return false;
        }
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    static function add_like($post_id){
        $db=DatabaseUtils::get_connection();
        try{
            //fetching post likes
            $stmt = $db->prepare("SELECT likes from posts WHERE post_id=:post_id;");
            $stmt->execute(array(':post_id'=>$post_id));
            $post=$stmt->fetch(PDO::FETCH_ASSOC);
            //incrementing post likes
            ++$post['likes'];
            //writing back to database
            $stmt = $db->prepare("UPDATE posts SET likes=:post_likes WHERE post_id=:post_id;");
            $stmt->execute(array(':post_id'=>$post_id
            ,':post_likes'=>$post['likes']));
        }catch(PDOException $e)
        {
            echo $stmt . "<br>" . $e->getMessage();
        }
        return $post['likes'];
    }
}
?>