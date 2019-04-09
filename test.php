<?php
require ("vendor/autoload.php");
if(!session_id()) {
    session_start();
}
/*Step 1: Enter Credentials*/
$fb = new \Facebook\Facebook([
    'app_id' => '519936365202713',
    'app_secret' => 'a415918ba3ffaf2f7cd2f32a2a92c8a9',
    'default_graph_version' => 'v2.10',
    //'default_access_token' => '{access-token}', // optional
]);
/*Step 2 Create the url*/
/*if(empty($access_token)) {
    echo "<a href='{$fb->getRedirectLoginHelper()->getLoginUrl("http://localhost/blog_system/test.php")}'>Login with Facebook </a>";
}*/
$fb->getRedirectLoginHelper()->getLoginUrl("http://localhost/blog_system/test.php");
/*Step 3 : Get Access Token*/
$access_token = $fb->getRedirectLoginHelper()->getAccessToken();
echo 2;
/*Step 4: Get the graph user*/
if(isset($access_token)) {
    try {
        $response = $fb->get('/me',$access_token);
        $fb_user = $response->getGraphUser();
        echo  $fb_user->getName();
    } catch (\Facebook\Exceptions\FacebookResponseException $e) {
        echo  'Graph returned an error: ' . $e->getMessage();
    } catch (\Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
    }
}