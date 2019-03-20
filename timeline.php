<!doctype html>
<html lang="en">
<head>
    <title>Blog Sytem-Timeline</title>
    <meta charset="utf-8">
</head>
<?php
require('queries.php');

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
        <h3 style="text-align: center;">Welcome <?php echo $_COOKIE['display_name'];?></h3>&nbsp&nbsp
        <a id="logout" href="logout.php">Logout</a>
        </div>
    </nav>
    <div class="post-col">
        <?php
        $posts=posts();
        foreach ($posts as $post) {
            echo "<div class='blog'>";
            echo "<h3>".$post['post_header']."</h3>" ;
            echo "<p>".$post['content']."</p>";
            echo "<button>Like it</button>";
            echo " <span>".$post['likes']." Likes</span></div>";
        }
        ?>
    </div>
</body>