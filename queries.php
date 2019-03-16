<?php
/**
 * Created by PhpStorm.
 * User: Raj
 * Date: 15-03-2019
 * Time: 14:04
 */
require('initialize.php');
function dname_check($display_name){
    global $db;
   // $sql = "SELECT * FROM users where display_name='".$display_name."';";
    //$result = mysqli_query($db,$sql);
    $stmt = $db->prepare("SELECT * FROM users where display_name='".$display_name."';");
    $stmt->execute();
    $result = $stmt->rowCount();
    return $result;
}
function email_check($email){
    global $db;
    //$sql = "SELECT * FROM users where email='".$email."';";
    //$result = mysqli_query($db,$sql);
    $stmt = $db->prepare("SELECT * FROM users where email='".$email."';");
    $stmt->execute();
    $result = $stmt->rowCount();
    return $result;
}
function adduser($name,$display_name,$email,$password){
    global $db;
    //$sql = "insert into users(name,display_name,email,password) values('".$name."','".$display_name."','".$email."','".$password."');";
    //$result = mysqli_query($db,$sql);
    try{
        $stmt = $db->prepare("insert into users(name,display_name,email,password) values('".$name."','".$display_name."','".$email."','".$password."');");
        $stmt->execute();
        return true;
    }
    catch(PDOException $e)
    {
        echo $stmt . "<br>" . $e->getMessage();
    }
   /* if($result) {
        return $result;
    } else {
        echo mysqli_error($db);
    }*/
}
function password_check($username,$v){
    global $db;
    if($v==1){
        //$sql = "select password from users where email='".$username."';";
       // $result = mysqli_query($db,$sql);
        $stmt = $db->prepare("select password from users where email='".$username."';");
        $stmt->execute();
    }
    else{
        //$sql = "select password from users where display_name='".$username."';";
        //$result = mysqli_query($db,$sql);
        $stmt = $db->prepare("select password from users where display_name='".$username."';");
        $stmt->execute();
    }
    $result = $stmt->fetch(PDO::FETCH_NUM);//fetch(PDO::FETCH_ASSOC);
    if($result) {
        return $result[0];
    } else {
        echo "Error";
    }
}
?>