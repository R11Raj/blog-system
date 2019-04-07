<?php
require_once '../utils/output-utils.php';
require_once '../utils/user-utils.php';
$user_info = SessionUtils::check_user_login_status();
if ($user_info['role']!='admin'){
    header('Location: ../login.php');
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Blog Sytem Log In</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"/>
</head>
<style>
    .nav-bar{
        width: 100%;
        height: 20%;
        background: blue;
        color: white;
    }
    .tab{
        display:block;
        height: 10em;
        width: 15em;
        background-color: black;
        margin: auto;
        color: white;
        margin-top: 10%;
        font-size: 25px;
    }
    .box-container{
        display: flex;
    }
    .tab:hover{
        text-decoration: none;
    }
    body{
        background-color: burlywood;
    }
</style>
<body>
<nav class="nav-bar text-center">
    <h1>Admin Panel</h1>
    <div class="user-function">
        <?php
        $user_info=SessionUtils::check_user_login_status();
        if($user_info){
            echo '<h3 style="text-align: center;">Welcome '.$user_info['display_name'].'</h3>';
        }
        ?>
        <a id="logout" class="btn btn-default like" href="logout.php">Logout</a>
    </div>
</nav>
<div class="box-container row text-center">
        <a class="tab" href="../timeline.php">

                Timeline

        </a>
        <a class="tab" href="users.php">

                User Panel

        </a>
        <a class="tab" href="posts.php">

                Post Panel

        </a>
</div>


</body>