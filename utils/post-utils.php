<?php
require('initialize.php');
class PostUtils{
    static function total_posts(){
        global $db;
        $stmt = $db->prepare("select count(*) from posts;");
        $result=$stmt->execute();
        return $result[0];
    }
    static function posts(){
        global $db;
        $stmt = $db->prepare("select * from posts;");
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
?>