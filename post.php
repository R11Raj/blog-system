<?php
require_once ('utils/user-utils.php');
require_once ('utils/post-utils.php');
require_once ('utils/output-utils.php');
$post_id=@$_GET['post_id'];
// Only display the post detail
$searched_post=PostUtils::get_post_detail($post_id);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="jquery-3.3.1.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Posts Panel</title>
</head>
<style>
    table{
        margin: auto;
    }
    .nav-bar{
        border: 2px solid black;
        background: blueviolet;
        color: white;
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
                echo '<a id="logout" class="btn btn-default btn-light" href="logout.php">Logout</a>';
            }else{
                echo '<h3 style="text-align: center;">Welcome</h3>';
            }
            echo '&nbsp&nbsp<a class="btn btn-default btn-light" href="index.php">Back to Timeline</a>';?>
        </div>
    </nav>
    <?php
    if(!$searched_post){
    $errors=OutputUtils::get_display_errors();
    foreach ($errors as $error){
    echo "<h3>".$error['message']."</h3>";
    }
    }else{ ?>

    <div class="col-md-12 update-inputs">
        <h3 class='text-center'>Post Detail</h3>
        <table cellpadding="10px" class="text-center">
            <tr>
                <td ><h3><?php echo $searched_post['post_header'];?></h3></td>
            </tr>
            <tr>
                <td ><h6>posted by <?php echo UserUtils::get_display_name($searched_post['user_id']);?></h6></td>
            </tr>
            <tr>
                <td ><h7><?php echo $searched_post['content'];?></h7></td>
            </tr>
            <tr>
                <td><?php echo '<button class="like-button" id="'.$post_id.'">Like it</button>';?>
                <h5 id="post_likes"> <?php echo $searched_post['likes'];?> Likes</h5></td>
            </tr>

        </table>
    </div>
    <?php } ?>

    <script>

        $(function(){
            var like_button=$('.like-button');
            like_button.click(function () {
                var post_id=$(this).attr('id');
                $.ajax('ajax.php?action=add_like',{
                    method: 'GET',
                    data: {
                        post_id:post_id,
                    },
                    success: function (response_json) {
                        response=JSON.parse(response_json);

                        document.getElementById("post_likes").innerHTML=response.data+' Likes';
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