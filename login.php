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
        SessionUtils::create_session($loggedUser['user_id'],$loggedUser['display_name']);
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

    <form action="#" method="post">
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