<?php
/**
 * Created by PhpStorm.
 * User: Raj
 * Date: 15-03-2019
 * Time: 14:04
 */
require('initialize.php');

function total_posts(){
    global $db;
    $stmt = $db->prepare("select count(*) from posts;");
    $result=$stmt->execute();
    return $result[0];
}
function posts(){
    global $db;
    $stmt = $db->prepare("select * from posts;");
    $stmt->execute();
    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
?>