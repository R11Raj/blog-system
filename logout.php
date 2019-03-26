<!doctype html>
<html lang="en">
<head>
    <title>Blog Sytem Log Out</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"/>
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
        background: blue;
        color:white;
    }
</style>
<body>
<nav class="nav-bar text-center">
    <h1 >Logged Out</h1>
</nav>
<div class="text-center">
<h4 >The user is logged out successfully..</h4>
<h4 >To login again <a href="login.php">click here..</a></h4>
</div>
</body>
