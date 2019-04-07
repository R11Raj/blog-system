<?php

require_once __DIR__ . '/utils/output-utils.php';
require_once 'utils/user-utils.php';
$user_info = SessionUtils::check_user_login_status();
if ($user_info){
    header('Location: timeline.php');
    exit();
}
if(isset($_POST['submit'])){
    $username=@$_POST['username'];
    $password=@$_POST['password'];
    $failed = 'Login failed...Username or Password is incorrect';
    $loggedUser=SessionUtils::username_password_check($username,$password);
    if(!$loggedUser)
    {
        OutputUtils::note_display_error($failed);
    }
    else{
        SessionUtils::create_session($loggedUser['user_id']);
        if($loggedUser['role']=='admin')
        {
            header('Location: '.'dashboard/index.php');
            exit();
        }
        header('Location: '.'timeline.php');
        exit();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>Blog Sytem Log In</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"/>
</head>
<style>
    .nav-bar{
        width: 100%;
        height: 20%;
        background: blue;
        color: white;
    }
    .main{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    label,input{
        display: block;
        margin-bottom: 20px;
    }
    button{
        display: flex;
        flex-direction: row;
        align-self: center;
    }
    ul{
        list-style-type: none;
        color: red;
    }
</style>
<body>
    <nav class="nav-bar text-center">
    <h1>Login</h1>
    </nav>
    <div class="main">
    <p><?php 
        if (OutputUtils::errors_exist()) {
            $errors = OutputUtils::get_display_errors();
            echo '<ul>';
            foreach($errors as $error)
            {
                echo '<li>'.$error['message'].'</li>';
            }
            echo '</ul>';
        } ?>
    </p>
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
        $permissions=['email'];
        if(empty($access_token)) {
            echo "<a href='{$fb->getRedirectLoginHelper()->getLoginUrl("http://localhost/blog_system/login.php",$permissions)}'>Sign Up/Sign In with Facebook </a>";
        }
        /*Step 3 : Get Access Token*/
        $access_token = $fb->getRedirectLoginHelper()->getAccessToken();
        /*Step 4: Get the graph user*/
        if(isset($access_token)) {
            try {
                $response = $fb->get('/me?fields=name,id,email,first_name',$access_token);
                $fb_user = $response->getGraphUser();

            } catch (\Facebook\Exceptions\FacebookResponseException $e) {
                echo  'Graph returned an error: ' . $e->getMessage();
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
            }
        }
        if(UserUtils::check_email_availibility($fb_user['email'])){
            if(!UserUtils::associate_facebook_account($fb_user['email'],'facebook',$access_token,$fb_user['id'])){
                OutputUtils::note_display_error('facebook account linking error');
                exit();
            }
            echo '<script>alert("facebook account linked successfully");</script>';
        }
        else{
            $uid=UserUtils::check_outh_uid('facebook',$fb_user['id'],$access_token);
            if($uid){
                SessionUtils::create_session($uid);
            }
            else{
                if(!UserUtils::add_user_using_facebook($fb_user['first_name'],$fb_user['name'],$fb_user['email'],'facebook',$access_token,$fb_user['id'])){
                    OutputUtils::note_display_error('user not added some error occured');
                }
                else{
                    echo '<script>alert("User account added successfully");</script>';
                }
            }
        }
        ?>
    <form action="" method="post">
        <table>
            <tr>
                <td><label>Display Name or Email Id</label></td><td><input type="text" required name="username"></td>
            </tr>
            <tr>
                <td><label>Password</label></td><td><input type="password" required name="password"></td>
            </tr>
            <tr>
                <td><button type="submit" name="submit" class="btn btn-success">Login</button></td>
            </tr>
        </table>
    </form>
    </div>
</body>