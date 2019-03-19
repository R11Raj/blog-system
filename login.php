<!doctype html>
<html lang="en">
<head>
    <title>Blog Sytem Log In</title>
    <meta charset="utf-8">
</head>
<?php
require('queries.php');
require_once __DIR__ . '/utils/output-utils.php';

if(isset($_POST['submit'])){
    $username=$_POST['username'];
    $password=$_POST['password'];
    $v=-1;
    $failed = 'Login failed.Username or Password is incorrect';
    if(preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $username))
    {
        if((email_check($username))!=1){
            OutputUtils::note_display_error($failed);
        }
        else{
            $v=1;
        }
    }
    else{
        if((dname_check($username))!=1){
            OutputUtils::note_display_error($failed);
        }
        else{
            $v=2;
        }
    }
    if($v>0){
        $tmp=(password_check($username,$v));
        if(password_verify($password,$tmp)){
            session_info($username,$password);
            echo "<script>alert('Login Successfull, Welcome ');</script>";
            header('Location: '.'timeline.php');
        }
        else{
            $login_error[]=$failed;
        }
    }
}
?>
<body>
    <h1>Login</h1>
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
    <div>

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