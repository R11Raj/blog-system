<!doctype html>
<html lang="en">
<head>
    <title>Blog Sytem-Timeline</title>
    <meta charset="utf-8">
</head>
<?php
require('utils/post-utils.php');
require('utils/user-utils.php');
?>
<style>
    .navbar{
        width: 100%;
        border: 2px solid black;
        background: blueviolet;
    }
    .title{
        text-align: center;
    }
    .post-col{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background: brown;
        overflow: hidden;
    }
    .blog{
        border: 2px solid red;
        width: 50%;
        background: aliceblue;
        margin-top: 2%;
        margin-bottom: 1%;
        padding: 1%;
    }
    .user-function{
        display: flex;
        flex-direction: row;
        justify-content: center;

    }
    #logout{
        align-self: center;
        margin-right: 5%;
        display: block;
        text-decoration: none;
        width: 70px;
        height: 25px;
        background: white;
        padding: 10px;
        text-align: center;
        border-radius: 5px;
        color: black;
        font-weight: bold;
    }
</style>
<body>
    <nav class="navbar">
        <h1 class="title">Timeline</h1>
        <div class="user-function">
        <?php
        $user_info=SessionUtils::check_user_login_status();
        if($user_info){
            echo '<h3 style="text-align: center;">Welcome '.$user_info['display_name'].'</h3>';
        }else{
            echo '<h3 style="text-align: center;">Welcome</h3>';
        }?>
        <a id="logout" href="logout.php">Logout</a>
        </div>
    </nav>
    <div class="post-col">
        <?php
        $posts=PostUtils::posts();
        foreach ($posts as $post) {
            echo "<div class='blog'>";
            echo "<h3>".$post['post_header']."</h3>" ;
            echo "<p>".$post['content']."</p>";
            echo "<button>Like it</button>";
            echo "<span>".$post['likes']." Likes</span></div>";
        }
        ?>
    </div>
</body>