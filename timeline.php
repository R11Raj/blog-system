<!doctype html>
<html lang="en">
<head>
    <title>Blog Sytem-Timeline</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"/>
</head>
<?php
require('utils/post-utils.php');
require('utils/user-utils.php');
?>
<style>
    .nav-bar{
        border: 2px solid black;
        background: blueviolet;
        color: white;
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
        display: block;
        background: white;
        padding: 10px;
        border-radius: 5px;
        color: black;
        font-weight: bold;
    }
</style>
<body>
    <nav class="nav-bar text-center">
        <h1 class="title">Timeline</h1>
        <div class="user-function">
        <?php
        $user_info=SessionUtils::check_user_login_status();
        if($user_info){
            echo '<h3 style="text-align: center;">Welcome '.$user_info['display_name'].'</h3>';
        }else{
            echo '<h3 style="text-align: center;">Welcome</h3>';
        }?>
        <a id="logout" class="btn btn-default like" href="logout.php">Logout</a>
        </div>
    </nav>
    <div class="post-col">
        <?php
        $posts=PostUtils::posts();
        foreach ($posts as $post) {
            echo "<div class='blog' id='blog-".$post['post_id']."'>";
            echo "<h3>".$post['post_header']."</h3>" ;
            echo "<p>".$post['content']."</p>";
            echo '<button id="'.$post['post_id'].'" class="like" >Like it</button>';
            echo "<span id='post-".$post['post_id']."'>".$post['likes']." Likes</span></div>";
        }
        ?>
    </div>
</body>
<script>
    function add_like() {
        var parent = this.parentElement;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'add_like.php', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if(xhr.readyState == 4 && xhr.status == 200) {
                var result = xhr.responseText;
                console.log('Result: ' + result);
                var element=parent.id;
                var id=element.split("-");
                document.getElementById("post-"+id[1]).innerHTML=result;
            }
        };
        xhr.send("post_id="+parent.id);
    }

    var buttons = document.getElementsByClassName("like");
    for(i=0; i < buttons.length; i++) {
        buttons.item(i).addEventListener("click", add_like);
    }

</script>
