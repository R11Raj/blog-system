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
    #sitemap{
        width: 20%;
        height: 100%;
        float: left;
    }
</style>
<body>
    <nav class="nav-bar text-center">
        <h1 class="title">Timeline</h1>
        <div class="user-function">
        <?php
        $user_info=SessionUtils::check_user_login_status();
        if($user_info){
            echo '<h3 style="text-align: center;">Welcome '.$user_info['display_name'].'</h3>&nbsp&nbsp';
            //echo '<a id="logout" class="btn btn-default like" href="logout.php">Logout</a>';
        }else{
            echo '<h3 style="text-align: center;">Welcome</h3>';
        }?>
        </div>
    </nav>
    <div id="sitemap">
        <h4 class="text-center">Site Navigation</h4>
        <ul>
            <li><a href="index.php">Timeline</a></li>
            <li><a href="edit_user_details.php?action=detail&user_id=<?php echo $user_info['user_id'];?>">Edit User</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="post-col">
        <div class="blog">
            <b><h5>Want to donate some money to this organization?? click here <a href="stripe_form.php" class="btn btn-success">Donate</a></h5></b>
        </div>
        <?php
        if(SessionUtils::user_has_permissions(UserUtils::PERMISSION_PUBLISH_POST,$user_info['user_id'])){
            echo '<div class="blog" id="">';
            echo '<h5>Want to write a new post??</h5>';
            echo '<a class="btn btn-success" href="add_post.php">click here</a>';
            echo '</div>';
        }

        $posts=PostUtils::posts();
        foreach ($posts as $post) {
            echo "<div class='blog' id='".$post['post_id']."'>";?>
            <a href=<?php echo 'post.php?post_id='.$post['post_id'];?> ><h3><?php echo $post['post_header'];?></h3></a>
            <?php
            if(SessionUtils::user_has_permissions(UserUtils::PERMISSION_EDIT_POST,$user_info['user_id']) && $post['user_id']==$user_info['user_id']){?>
                <a href=<?php echo 'edit_post.php?action=detail&post_id='.$post['post_id'];?> >Edit Post</a><br>
            <?php }
            echo "<h5>posted by ".UserUtils::get_display_name($post['user_id'])."    ".PostUtils::time_elapsed_string($post['time_date'])." ago</h5>";
            echo '<button class="like-button btn btn-success" >Like it</button>';
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
                    success: function (response_json) {
                        response=JSON.parse(response_json);

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
</html>
