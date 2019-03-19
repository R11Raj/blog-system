<?php
/**
 * Created by PhpStorm.
 * User: Raj
 * Date: 15-03-2019
 * Time: 10:54
 */
session_start();
include('database.php');
define("SIGN_UP", dirname(__FILE__));
$db = db_connect();
$errors=[];
function session_info($username,$password)
{
    session_regenerate_id();
    $_SESSION['username']=$username;
    $_SESSION['password']=$password;
    $_SESSION['last_login']=time();
    $_SESSION['session_expires']=time()+3600;
}