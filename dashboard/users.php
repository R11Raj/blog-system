<?php
/**
 * Created by PhpStorm.
 * User: nrohler
 * Date: 3/29/19
 * Time: 9:58 PM
 */
require_once ('../utils/user-utils.php');
require_once ('../utils/generic-utils.php');
$pageMode = 'master';
$detailID = null;
// users.php - master
// users.php?action=detail&user_id=4 - detail
// users.php?action=ajax  - ajax handler
function processRequest() {
    global $pageMode, $detailID;
    $action = @$_GET['action'];

    if ($action == 'detail') {
        // get the user id
        $user_id = @$_GET['user_id'];

        if (preg_match('|^[0-9]+$|i', $user_id)) {

            $pageMode = 'detail';
            $detailID = $user_id;
        }
    } elseif ($action == 'ajax') {
        $pageMode = 'ajax';

    }
}
processRequest();
if ($pageMode == 'detail') {
    // Get user information for the appropriate ID, etc etc
}
// Ajax handler
if ($pageMode == 'ajax') {
    // do some magic processing
    // write out header
    header('Content-Type: application/json');
    $ajaxAction = @$_GET['ajax_action']; // users.php?action=ajax&ajax_action=update_permissions
    // do all processing here etc
    // write out response
    $user_id=@$_POST['userID'];
    $permissions=@$_POST['permissions'];
    $updated_permissions=@$_POST['updated_permissions'];

    $userState = SessionUtils::check_user_login_status();
    if (!$userState)
        OutputUtils::writeAjaxError('Invalid login');
   /* if (!SessionUtils::user_has_permissions(UserUtils::PERMISSION_EDIT_POST,$userState['user_id']))
        OutputUtils::writeAjaxError('You cannot edit this post due to invalid permissions');*/
    if($userState['role']!='admin'){
        OutputUtils::writeAjaxError('You Don\'t have the required permissions to update');
        exit();
    }

    if($permissions==$updated_permissions){
        OutputUtils::writeAjaxSuccess('User permissions updated successfully',$permissions);
    }
    else{
        $permissions_to_be_deleted=array_diff($permissions, $updated_permissions);
        $permissions_to_be_added=array_diff($updated_permissions,$permissions);

        if(!empty($permissions_to_be_deleted)){
            if(UserUtils::delete_user_permissions($user_id,$permissions_to_be_deleted)){
                OutputUtils::writeAjaxSuccess('User permissions updated successfully',$updated_permissions);
            }
            else{
                OutputUtils::writeAjaxError('failed');
            }
        }else if(!empty($permissions_to_be_added)){
            if(UserUtils::add_user_permissions($user_id,$permissions_to_be_added)){
                OutputUtils::writeAjaxSuccess('User permissions updated successfully',$updated_permissions);

            }
            else{
                OutputUtils::writeAjaxError('failed');
            }
        }
    }
    exit; //<-- SUPER IMPORTANT
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="../jquery-3.3.1.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Users Panel</title>
</head>
<style>
    table{
        margin: auto;

    }
    .bg-dark{
        height: 20%;
    }
</style>
<body>
<!-- master / detail for users -->
<h1 class="text-primary text-center bg-dark">Users Panel</h1>

<?php if ($pageMode == 'master') {
    $users=SessionUtils::users_list();
    // Full user table goes here
    ?>
    <br>
    <table border="1px solid black" class="text-center" cellpadding="10px">
        <tr><th>User ID</th>
            <th>User Name</th>
            <th>Display Name</th>
            <th>Email ID</th>
            <th></th>
        </tr>
    <?php    foreach ($users as $user) { ?>
        <tr>
            <td><?php echo $user['user_id'];?></td>
            <td><?php echo $user['NAME'];?></td>
            <td><?php echo $user['display_name'];?></td>
            <td><?php echo $user['email'];?></td>
            <td><a class="action" href="<?php echo 'users.php?action='.GenericUtils::u('detail').'&user_id='.$user['user_id']; ?>">Details</a></td>
        </tr>
    <?php    } ?>
    </table>


<?php } elseif ($pageMode == 'detail') {

    // Only display the user detail
    $searched_user=SessionUtils::get_user_details($detailID);
    if(!$searched_user){
        $errors=OutputUtils::get_display_errors();
        foreach ($errors as $error){
            echo "<br><h3 class='text-center'>".$error['message']."</h3>";
        }
    }
    else{ ?>
        <div id="<?php echo $searched_user['user_id'];?>"><h3 class="text-center">User Found!!</h3><br>
        <table cellpadding="10px">
        <tr>
            <td><h5>User ID: </h5></td>
            <td class="text-info"><h6><?php echo $searched_user['user_id'];?></h6></td>
        </tr>
        <tr>
            <td><h5>Name: </h5></td>
            <td class="text-info"><h6><?php echo $searched_user['NAME'];?></h6></td>
        </tr>
        <tr>
            <td><h5>Display Name: </h5></td>
            <td class="text-info"><h6><?php echo $searched_user['display_name'];?></h6></td>
        </tr>
        <tr>
            <td><h5>Email ID: </h5></td>
            <td class="text-info"><h6><?php echo $searched_user['email'];?></h6></td>
        </tr>
        </table>

        <br>
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">

                    <h2 >Permissions</h2>
                    <br>
                    <p>Check/uncheck boxes for various permissions:</p>

                    <form action="" id="permission-form">
                        <?php
                        $rows = SessionUtils::user_permissions($detailID);
                        $currentPermissions = array();
                        if(!empty($rows)){
                            foreach ($rows as $row) {
                                $currentPermissions[] = $row['permission'];
                            }
                        }

                        // possible permission list... should be stored in UserUtils class...
                        $possiblePermissions = UserUtils::getPossiblePermissions();
                        // Loop through all of the permissions
                        foreach ($possiblePermissions as $permission) {
                            // add checkbox for each of those values, check based on in_array($currentPermissions, $permission)
                            if (in_array($permission,$currentPermissions)){
                                echo '<input type="checkbox" checked value="'.$permission.'" id="'.$permission.'">'.$permission;
                            }
                            else{
                                echo '<input type="checkbox" value="'.$permission.'" id="'.$permission.'">'.$permission;
                            }
                            echo '&nbsp&nbsp&nbsp';
                        }
                        ?>
                    </form>
                    <br>
                    <button id="update-button" class="btn btn-success" disabled>Update Permissions</button>
                </div>
            </div>
        </div>
    <?php } ?>





    <script>
        // already have jquery
        $(function() {
            var checkboxes = $('#permission-form input[type=checkbox]');
            var update_button=$('#update-button');
            var updated_permissions = new Array();
            var permissions=new Array();
            $('input:checked').each(function () {
                permissions.push($(this).val());
            });
            checkboxes.click(function() {
                // loop through all of the checkboxes and see which ones are selected; based on that, build a list
                updated_permissions=[];
                $('input:checked').each(function () {
                    updated_permissions.push($(this).val());
                });
                update_button.attr('disabled',false);
            });
            update_button.click(function () {
                if(confirm('Are you sure you want to update the permissions?')) {

                    $.ajax('users.php?action=ajax&ajax_action=update_permissions', {
                        method: 'POST',
                        data: {
                            userID:<?php echo $detailID;?>,
                            permissions: permissions,
                            updated_permissions: updated_permissions
                        }
                        ,
                        success: function (response_json) {
                            response=JSON.parse(response_json);
                            permissions=response.data;
                            alert(response.message);
                            update_button.attr('disabled',true);
                        },
                        error:function(jqXHR, textStatus, errorThrown ) {
                        console.log( 'Could not get posts, server response: ' + textStatus + ': ' + errorThrown );}
                      /*  error: function (e) {
                            alert('error');
                        }*/
                    });
                }
            });
        });

    </script>
<?php } //end $pageMode switching ?>
</body>
</html>