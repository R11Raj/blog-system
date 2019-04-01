<?php
/**
 * Created by PhpStorm.
 * User: Raj
 * Date: 31-03-2019
 * Time: 12:48
 */
require ('../utils/post-utils.php');
require ('../utils/generic-utils.php');
$pageMode='master';
$detailID=null;
function processRequest() {
    global $pageMode, $detailID;
    $action = @$_GET['action'];
    if ($action == 'detail') {
        // get the user id
        $post_id = @$_GET['post_id'];

        if (preg_match('|^[0-9]+$|i', $post_id)) {

            $pageMode = 'detail';
            $detailID = $post_id;
        }
    }
}
processRequest();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="../jquery-3.3.1.js"></script>
    <title>Posts detail</title>
</head>
<body>
<?php if ($pageMode == 'master') {
    $posts=PostUtils::posts();
    // Full post table goes here
    ?>
    <table>
        <tr><th>Post ID</th>
            <th>User ID</th>
            <th>Content</th>
            <th>Likes</th>
            <th>Post Header</th>
        </tr>
        <?php    foreach ($posts as $post) { ?>
            <tr>
                <td><?php echo $post['post_id'];?></td>
                <td><?php echo $post['user_id'];?></td>
                <td><?php echo $post['content'];?></td>
                <td><?php echo $post['likes'];?></td>
                <td><?php echo $post['post_header'];?></td>
                <td><a class="action" href="<?php echo 'posts.php?action='.GenericUtils::u('detail').'&post_id='.$post['post_id']; ?>">Details</a></td>
            </tr>
        <?php    } ?>
    </table>


<?php } elseif ($pageMode == 'detail') {

    // Only display the user detail
    $searched_post=PostUtils::get_post_detail($detailID);
    if(!$searched_post){
        $errors=OutputUtils::get_display_errors();
        foreach ($errors as $error){
            echo "<h3>".$error['message']."</h3>";
        }
    }else{ ?>
    <div class='text-center' id="<?php echo $searched_post['post_id'];?>"><h3>Post Found</h3>
        <h4 >Post ID: <?php echo $searched_post['post_id'];?></h4>
        <h4 >User ID: <?php echo $searched_post['user_id'];?></h4>
        <h4>Content: <textarea ><?php echo $searched_post['content'];?></textarea></h4>
        <h4>likes: <?php echo $searched_post['likes'];?></h4>
        <h4>Post header: <input type="text" value="<?php echo $searched_post['post_header'];?>"></h4>


   <?php }
}?>
</body>
</html>