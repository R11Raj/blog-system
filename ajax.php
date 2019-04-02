
<?php
require('utils/post-utils.php');
require ('utils/output-utils.php');
require ('utils/user-utils.php');
function processRequest()
{
    $action = @$_GET['action'];
    if ($action == 'edit_post') {

        header('Content-Type: application/json');
        // Verify the user
        $userState = SessionUtils::check_user_login_status();
        if (!$userState)
            OutputUtils::writeAjaxError('Invalid login');
        if (!SessionUtils::user_has_permissions(UserUtils::PERMISSION_EDIT_POST,$userState['user_id']))
            OutputUtils::writeAjaxError('You cannot edit this post due to invalid permissions');

        // 1. grab all of the fields - post_id, title, content, etc
        $post_id=@$_GET['post_id'];
        $content=@$_GET['content'];
        $post_header=@$_GET['post_header'];
        // 1.5. verify all of the fields
        function validate($post_id,$content,$post_header){
            if(!is_numeric($post_id)){
                return false;
            }
            if($content==''){
                return false;
            }
            if($post_header==''){
                return false;
            }
            return true;
        }
        if(!validate($post_id,$content,$post_header)){
            OutputUtils::writeAjaxError('You cannot have post fields empty');
        }
        if(!PostUtils::update_post($post_id,$content,$post_header))
        {
            OutputUtils::writeAjaxError('Error!! Post not updated');
        }
        OutputUtils::writeAjaxSuccess('Post Updated successfully');
        // 2. update the database
        // 3. write the success message via OutputUtils::writeAjaxSuccess
        exit();
    }
    // imagine in posts.php....
    //     $.ajax('ajax.php', {method:'POST',
    //          data:$('#formidname').serialize()
    //      }).done(function(response) {
    //          if (!response.success) {
    //              alert(response.message);
    //              return;
    //          }
    //          // this is a valid response and we can use .data / .message
    //
    //    });
    if($action=='add_like'){
        header('Content-Type: application/json');
        if(isset($_GET['post_id'])) {

            $post_id = @$_GET['post_id'];
            $response = PostUtils::add_like($post_id);
            //echo  $response;
            OutputUtils::writeAjaxSuccess('successfull',$response);
            exit;
        }
    }
}
processRequest();
?>
