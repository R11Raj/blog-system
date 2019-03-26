<?php
require('utils/post-utils.php');
function is_ajax_request() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}

if(!is_ajax_request()) { exit; }
$raw=isset($_POST['post_id'])?$_POST['post_id']:'';
if(preg_match("/blog-(\d+)/", $raw, $matches))
    $id = $matches[1];
if($id){
    $ans=PostUtils::add_like($id);
    echo $ans;
}
?>
