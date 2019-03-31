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
    echo '<script>console.log(5);</script>';
    $ajaxAction = @$_GET['ajax_action']; // users.php?action=ajax&ajax_action=update_permissions
    // do all processing here etc
    // write out response
    $output = array('valid'=>true, 'message'=>'Did some processing hey!');
    echo json_encode($output);
    exit; //<-- SUPER IMPORTANT
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Users detail</title>
</head>
<body>

<!-- master / detail for users -->

<?php if ($pageMode == 'master') {
    $users=SessionUtils::users_list();
    $v='detail';
    // Full user table goes here
    ?>
    <table>
        <tr><th>User ID</th>
            <th>User Name</th>
            <th>Display Name</th>
            <th>Email ID</th>
        </tr>
    <?php    foreach ($users as $user) { ?>
        <tr>
            <td><?php echo $user['user_id'];?></td>
            <td><?php echo $user['NAME'];?></td>
            <td><?php echo $user['display_name'];?></td>
            <td><?php echo $user['email'];?></td>
            <td><a class="action" href="<?php echo 'users.php?action='.GenericUtils::u($v).'&user_id='.$user['user_id']; ?>">Details</a></td>
        </tr>
    <?php    } ?>
    </table>


<?php } elseif ($pageMode == 'detail') {

    // Only display the user detail
    $searched_user=SessionUtils::get_user_details($detailID);
    if(!$searched_user){
        $errors=OutputUtils::get_display_errors();
        foreach ($errors as $error){
            echo "<h3>".$error['message']."</h3>";
        }
    }
    else{ ?>
        <div class='text-center' id="<?php echo $searched_user['user_id'];?>"><h3>User Found</h3>
        <h4 >User ID: <?php echo $searched_user['user_id'];?></h4>
        <h4>Name: <?php echo $searched_user['NAME'];?></h4>
        <h4>Display Name: <?php echo $searched_user['display_name'];?></h4>
        <h4>Email ID: <?php echo $searched_user['email'];?></h4>

    // Include form for updating role, permissions etc

        <div class="container">

            <div class="row">
                <div class="col-md-12">

                    <h2>Permissions</h2>
                    <p>Check/uncheck boxes for various permissions:</p>
                    <form action="" id="permission-form">
                        <?php
                        $rows = SessionUtils::user_permissions($detailID);
                        $currentPermissions = array();
                        foreach ($rows as $row) {
                            $currentPermissions[] = $row['permission'];
                        }
                        // possible permission list... should be stored in UserUtils class...
                        $possiblePermissions = UserUtils::getPossiblePermissions();
                        // Loop through all of the permissions
                        foreach ($possiblePermissions as $permission) {
                            // add checkbox for each of those values, check based on in_array($currentPermissions, $permission)
                            if (in_array($permission,$currentPermissions)){
                                echo '<input type="checkbox" checked>'.$permission;
                            }
                            else{
                                echo '<input type="checkbox">'.$permission;
                            }
                        }
                        ?>
                    </form>
                </div>
            </div>

        </div>
    <?php } ?>





    <script>
        // already have jquery
        $(function() {
            var checkboxes = $('#permission-form input[type=checkbox]');
            checkboxes.click(function(){
                // loop through all of the checkboxes and see which ones are selected; based on that, build a list
               $.ajax('users,php?action=ajax&ajax_action=update_permissions', {
                    method:'GET',
                    data: {
                        userID:<?php echo $detailID;?>,
                        permissions:'hello'
                    }
                });.success(function(){
                    // notify of success
                    //alert('success');
                }).fail(function(){
                    // alert user of failture
                });

            });
        });
    </script>
<?php } //end $pageMode switching ?>
</body>
</html>