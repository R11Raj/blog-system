<?php
require_once ('utils/user-utils.php');
require_once ('utils/post-utils.php');
require_once ('utils/output-utils.php');
$user_info=SessionUtils::check_user_login_status();
if(isset($_POST['submit']))
{
    $post_header=$_POST['post_header'];
    $post_content=$_POST['content'];
    function validate($post_header,$post_content){
        if($post_header=='' || $post_content==''){
            OutputUtils::note_display_error('Post header or content cannot be empty');
            return false;
        }
        return true;
    }
    if(!validate($post_header,$post_content)){
        OutputUtils::set_page_mode('error');
    }
    else{
        $post_header=htmlspecialchars($post_header);
        $post_content=htmlspecialchars($post_content);
        if(PostUtils::add_post($user_info['user_id'],$post_header,$post_content)){
            OutputUtils::set_page_mode('post added');
        }
        else{
            OutputUtils::note_display_error('Post not added some error occured');
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="jquery-3.3.1.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Add Post</title>
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
    .blog{
        margin-top: 2%;
        margin-left: 10%;
    }
</style>
<body>
    <nav class="nav-bar text-center">
        <h1 class="title">Publish a Post</h1>
        <div class="user-function">
            <?php
            if($user_info){
                echo '<h3 style="text-align: center;">Welcome '.$user_info['display_name'].'</h3>';
                echo '<a id="logout" class="btn btn-default btn-light" href="logout.php">Logout</a>';
            }else{
                echo '<h3 style="text-align: center;">Welcome</h3>';
            }
            echo '&nbsp&nbsp<a class="btn btn-default btn-light" href="index.php">Back to Timeline</a>';?>
        </div>
    </nav>
    <br>
    <p><?php
        $page_mode=OutputUtils::get_page_mode();
        if($page_mode=='error' || $page_mode==''){
            if(isset($_POST['submit']) && count(OutputUtils::get_display_errors())>0){
                echo "Following errors are there:";
                echo "<ul>";
                $errors=OutputUtils::get_display_errors();
                foreach($errors as $error)
                {
                    echo "<li>".$error['message']."</li>";
                }
            }
        }elseif ($page_mode=='post added'){
            echo '<h4 style="color:green;text-align: center;">Post added Successfully please check your timeline  <a href="index.php"> click here to open timeline</a> </h4>';
        }
        ?>
    </p>

    <?php if(OutputUtils::get_page_mode()!='post added'){ ?>
    <h4 class="text-center">Write a new post</h4>
    <div class="blog">
        <form action="add_post.php" method="post">
        <h5>Post Header:</h5>
        <input type="text" name="post_header" required value="<?php echo isset($_POST['post_header']) ? $_POST['post_header'] : '';?>">
        <h5>Content:</h5>
        <textarea name="content" style="width: 80%;height: 150px;" value="<?php echo isset($_POST['content']) ? $_POST['content'] : '';?>"></textarea><br>
        <button type="submit" name="submit" class="btn btn-success">Post it</button>
        </form>
    </div>
    <?php } ?>
</body>
</html>