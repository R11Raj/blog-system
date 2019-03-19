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

</style>
<body>
    <nav class="navbar">
        <h1 class="title">Timeline</h1>
        <h4 style="margin-left: 10%;">Welcome,<?php echo $_COOKIE['user_id'];?></h4>
        <a href="logout.php">Logout</a>
    </nav>
    <div class="post-col" style="border: 2px solid green;">
        <?php
        $posts=posts();
        foreach ($posts as $post) {
            echo "<div class='blog' style=''>";
            echo "<h3>".$post['post_header']."</h3>" ;
            echo "<p>".$post['content']."</p>";
            echo "<button>Like it</button>";
            echo " <span>".$post['likes']." Likes</span></div>";
        }
        ?>
    </div>
</body>