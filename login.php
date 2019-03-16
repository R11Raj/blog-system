<!doctype html>
<html lang="en">
<head>
    <title>Blog Sytem Sign-up</title>
    <meta charset="utf-8">
</head>
<?php
require('queries.php');
$login_error=[];
if(isset($_POST['submit'])){
    $username=$_POST['username'];
    $password=$_POST['password'];
    $v=1;
    if(preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $username))
    {
        if(mysqli_num_rows(email_check($username))!=1){
            $login_error[]="Your Email Id is not registered";
            $v=1;
        }
    }
    else{
        if(mysqli_num_rows(dname_check($username))!=1){
            $login_error[]="Invalid username";
            $v=2;
        }
    }
    if($v>0){
        $tmp=mysqli_fetch_row(password_check($username,$v));
        if(password_verify($password,$tmp[0])){
            echo "<script>alert('Login Successfull');</script>";
        }
        else{
            $login_error[]="Password is incorrect";
        }
    }
}
?>
<body>
    <h1>Login</h1>
    <p><?php global $login_error;
        if(isset($_POST['submit']) && count($login_error)>0){
            echo "<ul>";
            foreach($login_error as $error)
            {
                echo "<li>".$error."</li>";
            }
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
</body>