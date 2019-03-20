<!doctype html>
<html lang="en">
<head>
    <title>Blog Sytem Log In</title>
    <meta charset="utf-8">
</head>
<?php
require('queries.php');
require_once __DIR__ . '/utils/output-utils.php';
require_once 'utils/user-utils.php';
$user_info = SessionUtils::check_user_login_status();
if ($user_info){
    header('Location: timeline.php');
}
if(isset($_POST['submit'])){
    $username=$_POST['username'];
    $password=$_POST['password'];
    $v=-1;
    $failed = 'Login failed.Username or Password is incorrect';
    $loggedUser=SessionUtils::username_password_check($username,$password);
    if(!$loggedUser)
    {
        OutputUtils::note_display_error($failed);
        exit();
    }
    echo "<script>alert('Login Successfull, Welcome ');</script>";
    SessionUtils::create_session($loggedUser['user_id'],$loggedUser['display_name']);
    header('Location: '.'timeline.php');
}
?>
<style>
    .nav-bar{
        width: 100%;
        height: 20%;
        text-align: center;
        background: blue;
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
</style>
<body>
    <nav class="nav-bar">
    <h1 style="color: white;">Login</h1>
    </nav>
    <div class="main">
    <p><?php 
        if (OutputUtils::errors_exist()) {
            $errors = OutputUtils::get_display_errors();
            echo '<ul>';
            foreach($errors as $error)
            {
                echo '<li>'.$error.'</li>';
            }
            echo '</ul>';
        } ?>
    </p>

    <form action="#" method="post">
        <table>
            <tr>
                <td><label>Display Name or Email Id</label></td><td><input type="text" required name="username"></td>
            </tr>
            <tr>
                <td><label>Password</label></td><td><input type="password" required name="password"></td>
            </tr>
            <tr>
                <td><button type="submit" name="submit">Login</button></td>
            </tr>
        </table>
    </form>
    </div>
</body>