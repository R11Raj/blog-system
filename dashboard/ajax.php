<?php
/**
 * Created by PhpStorm.
 * User: nrohler
 * Date: 4/1/19
 * Time: 10:35 PM
 */

require_once __DIR__.'/../utils/database.php';
require_once __DIR__.'/../utils/user-utils.php';
require_once __DIR__.'/../utils/output-utils.php';


function processRequest()
{
    $action = @$_GET['action'];

    if ($action == 'edit_post') {

        // Verify the user
        $userState = SessionUtils::check_user_login_status();
        if (!$userState)
            OutputUtils::writeAjaxError('Invalid login');
        if (!SessionUtils::user_has_permission(UserUtils::PERMISSION_EDIT_POST))
            OutputUtils::writeAjaxError('You cannot edit this post due to invalid permissions');

        // 1. grab all of the fields - post_id, title, content, etc
        // 1.5. verify all of the fields
        // 2. update the database
        // 3. write the success message via OutputUtils::writeAjaxSuccess

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


}
processRequest();