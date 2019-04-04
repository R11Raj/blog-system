<?php
require_once '../utils/output-utils.php';
require_once '../utils/user-utils.php';
$user_info = SessionUtils::check_user_login_status();
if ($user_info['role']!='admin'){
    header('Location: ../login.php');
    exit();
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

</style>
<body>
<nav class="nav-bar text-center">
    <h1>Admin Panel</h1>
</nav>
<div>

</div>
</body>