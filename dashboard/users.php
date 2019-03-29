<?php
/**
 * Created by PhpStorm.
 * User: nrohler
 * Date: 3/29/19
 * Time: 9:58 PM
 */

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

    //
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
    <title>Users detail</title>
</head>
<body>

<!-- master / detail for users -->

<?php if ($pageMode == 'master') { ?>


    // Full user table goes here


<?php } elseif ($pageMode == 'detail') { ?>


    // Only display the user detail


    // Include form for updating role, permissions etc

    <div class="container">

        <div class="row">
            <div class="col-md-12">

                <h2>Permissions</h2>
                <p>Check/uncheck boxes for various permissions:</p>
                <form action="" id="permission-form">
                    <?php
                    $sql = 'SELECT * FROM user_permissions WHERE user_id=:user_id';
                    $stmt->execute(array(':user_id'=>$detailID));
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $currentPermissions = array();
                    foreach ($rows as $row) {
                        $currentPermissions[] = $row['permission'];
                    }

                    // possible permission list... should be stored in UserUtils class...
                    $possiblePermissions = UserUtils::getPossiblePermissions();

                    // Loop through all of the permissions
                    foreach ($possiblePermissions as $permission) {
                        // add checkbox for each of those values, check based on in_array($currentPermissions, $permission)
                    }
                    ?>
                </form>
            </div>
        </div>

    </div>




// already have jquery
<script>
    $(function() {

        var checkboxex = $('#permission-form input[type=checkbox]');
        checkboxes.click(function(){
            // loop through all of the checkboxes and see which ones are selected; based on that, build a list
            $.ajax('users,php?action=ajax&ajax_action=update_permissions', {
                method:'POST',
                data: {
                    userID: <?php  ?>,
                    permissions:....etc....
                }
            }).success(function(){
                // notify of success
                alert('success');
            }).fail(function(){
                // alert user of failture
            });
        });

    });
</script>

<?php } //end $pageMode switching ?>
</body>
</html>
