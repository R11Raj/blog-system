<!doctype html>
<html lang="en">
<head>
    <title>Blog Sytem Log Out</title>
    <meta charset="utf-8">
</head>
<?php
/**
 * Created by PhpStorm.
 * User: Raj
 * Date: 20-03-2019
 * Time: 09:59
 */
require_once (__DIR__.'/utils/database.php');
$db = DatabaseUtils::get_connection();
try{
    $session_code=@$_COOKIE['app_session_code'];
    $stmt = $db->prepare('UPDATE user_sessions SET is_valid=0 WHERE session_code=:session_code;');
    $stmt->execute(array(':session_code'=>$session_code));
    setcookie('app_session_code',false ,time()-3600, '/' );
}
catch(PDOException $e)
{
    echo $stmt . "<br>" . $e->getMessage();
}
?>
<style>
    .nav-bar{
        width: 100%;
        height: 20%;
        text-align: center;
        background: blue;
    }
    .text{
        text-align: center;
    }
</style>
<body>
<nav class="nav-bar">
    <h1 style="color: white;">Logged Out</h1>
</nav>
<h3 class="text">The user is logged out successfully..</h3>
<h3 class="text">To login again <a href="login.php">click here..</a></h3>

</body>
