<!doctype html>
<html lang="en">
  <head>
    <title>Blog Sytem Sign-up</title>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width,initial-scale=1">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
<?php

require('queries.php');
if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $display_name = $_POST['display_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['confirm_password'];
    function validate($name, $display_name,$email, $password, $cpassword)
    {     global $errors;
        $v=1;
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $errors[]="invalid first name";
            $v=0;
        }
        if(strlen($password)<8){
            $errors[]="Password should be atleast 8 characters long";
            $v=0;
        }
        if(strlen($display_name)<4){
            $errors[]="Display Name should be atleast 4 characters long";
            $v=0;
        }
        if((dname_check($display_name))==1){
            $errors[]="Display name already Taken";
            $v=0;
        }
        if((email_check($email))==1){
            $errors[]="Email Id already Taken";
            $v=0;
        }
        if ($password != $cpassword) {
            $errors[]="Passwords don't match";
            $v=0;
        }
        return $v;
    }
    $v=validate($name, $display_name,$email, $password, $cpassword);
    if ($v==1){
        $password=password_hash($password,PASSWORD_BCRYPT);
        $result=adduser($name,$display_name,$email,$password);
        if($result){
            echo "<script>alert('User added Successfully');</script>";
        }

    }
}?>
  <body>
        <h1 class="center">Sign Up</h1>
        <p><?php global $errors;
            if(isset($_POST['submit']) && count($errors)>0){
                echo "Following errors are there:";
                echo "<ul>";
                foreach($errors as $error)
                {
                    echo "<li>".$error."</li>";
                }
            } ?>
        </p>
        <form action="#" method="post">
            <table>
            <tr>
                <td><label>Name</label></td><td><input type="text" name="name" required value="<?php echo isset($_POST['name']) ? $_POST['name'] : '';?>"></td>
            </tr>
            <tr>
                <td><label>Display Name</label></td><td><input type="text" name="display_name" required value="<?php echo isset($_POST['display_name']) ? $_POST['display_name'] : '';?>"></td>
            </tr>
            <tr>
                <td><label>Email address</label></td><td><input type="email" name="email" required value="<?php echo isset($_POST['email']) ? $_POST['email'] : '';?>"></td>
            </tr>
            <tr>
                <td><span><br>password should be atleast 8 characters long</span></td>
            </tr>
            <tr>
                <td><label>Password</label></td><td><input type="password" name="password" required></td>
            </tr>
            <tr>
                <td><label>Confirm Password</label></td><td><input type="password" name="confirm_password" required></td>
            </tr>
            <tr>
                <td><button type="submit" name="submit">Submit</button></td>
            </tr>
            </table>
        </form>
  </body>
</html>

<form>
