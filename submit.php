<?php
if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $display_name = $_POST['display_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['confirm_password'];
    function validate($name, $display_name, $password, $cpassword)
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
        if ($password != $cpassword) {
            $errors[]="Passwords don't match";
            $v=0;
        }
        return $v;
    }
    $v=validate($name, $display_name, $password, $cpassword);
    if ($v==0){
        echo $errors[1];
          // header("Location: ".$root);
    }
    else{
        echo "<script>alert('Successfull');</script>";
    }
}?>