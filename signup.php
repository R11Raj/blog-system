<!doctype html>
<html lang="en">
  <head>
    <title>Blog Sytem Sign-up</title>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width,initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"/>
  </head>
<?php
require('utils/post-utils.php');
require('utils/user-utils.php');
require ('utils/output-utils.php');
if(isset($_POST['submit'])) {
    $name = @$_POST['name'];
    $display_name = @$_POST['display_name'];
    $email = @$_POST['email'];
    $password = @$_POST['password'];
    $cpassword = @$_POST['confirm_password'];
    function validate($name, $display_name,$email, $password, $cpassword)
    {
        if (!preg_match("/^[a-zA-Z -]*$/", $name)) {
            OutputUtils::note_display_error("invalid first name");
        }
        if(strlen($password)<8){
            OutputUtils::note_display_error("Password should be atleast 8 characters long");
        }
        if(strlen($display_name)<4){
            OutputUtils::note_display_error("Display Name should be atleast 4 characters long");
        }
        if(!UserUtils::check_display_name_availibility($display_name)){
            OutputUtils::note_display_error("Display name already Taken");
        }
        if(!UserUtils::check_email_availibility($email)){
            OutputUtils::note_display_error("Email Id already Taken");
        }
        if ($password != $cpassword) {
            OutputUtils::note_display_error("Passwords don't match");
        }
    }
    validate($name, $display_name,$email, $password, $cpassword);
    if (count(OutputUtils::get_display_errors())==0){
        $password=password_hash($password,PASSWORD_BCRYPT);
        $result=UserUtils::add_user($name,$display_name,$email,$password);
        if($result){
            OutputUtils::set_page_mode('user added');
        }else{
            OutputUtils::set_page_mode('error');
        }
    }
    else{
        OutputUtils::set_page_mode('error');
    }
}?>
  <style>
      .nav-bar{
          height: 30%;
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
      li{
          color:red;
      }
  </style>
  <body>
        <nav class="nav-bar text-center">
            <h1>Sign Up</h1>
        </nav>
        <div class="main">
        <p><?php
            $page_mode=OutputUtils::get_page_mode();
            if($page_mode=='error' || $page_mode=='form' || $page_mode==''){
                if(isset($_POST['submit']) && count(OutputUtils::get_display_errors())>0){
                    echo "Following errors are there:";
                    echo "<ul>";
                    $errors=OutputUtils::get_display_errors();
                    foreach($errors as $error)
                    {
                        echo "<li>".$error['message']."</li>";
                    }
                }
            }elseif ($page_mode='user added'){
                echo '<h4 style="color:green;text-align: center;">User added Successfully please log in to the system  <a href="login.php"> click here to open log in page</a> </h4>';
            }
            ?>
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
                <td><span><br>**password should be atleast 8 characters long</span></td>
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
        </div>
  </body>
</html>

<form>
