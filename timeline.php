<!doctype html>
<html lang="en">
<head>
    <title>Blog Sytem-Timeline</title>
    <meta charset="utf-8">
    <script src="jquery-3.3.1.js"></script>
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
            echo "<div class='blog' id='".$post['post_id']."'>";
            echo "<h3>".$post['post_header']."</h3>" ;
            echo "<p>".$post['content']."</p>";
            echo '<button class="like-button" >Like it</button>';
            echo "<span id='post-".$post['post_id']."'>".$post['likes']." Likes</span></div>";
        }
        ?>
    </div>
    <script>

        $(function(){
            var like_button=$('.like-button');
            like_button.click(function () {
                var post_id=$(this).parent().attr('id');
                $.ajax('ajax.php?action=add_like',{
                    method: 'GET',
                    data: {
                        post_id:post_id,
                    },
                    success: function (response) {
                        console.log(response.data);
                        document.getElementById("post-"+post_id).innerHTML=response.data+' Likes';
                    },
                    error: function (e) {
                        alert('error');
                    }
                });
            });
        });
    </script>

</body>
