<?php
require('utils/user-utils.php');
require('utils/output-utils.php');
?>
<!doctype html>
<html lang="en">
<head>
    <title>Blog Sytem-Dashboard</title>
    <meta charset="utf-8">
</head>
<style>
    .nav-bar{
        width: 100%;
        border: 2px solid black;
        background: blueviolet;
    }
    .center{
        text-align: center;
    }
    table{
        border: 2px solid black;
    }
    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
</style>
<body>
<nav class="nav-bar">
    <h1 class="center">Dashboard</h1>
</nav>
<h3>Search User</h3>
<form action="dashboard.php" method="post">
    <label>Enter Display Name or Email ID</label><input type="text" required name="user_name">
    <button type="submit">Search User</button>
</form>
<?php
    if(isset($_POST['user_name'])){
        $searched_user=SessionUtils::get_user_details($_POST['user_name']);
        if(!$searched_user){
            $errors=OutputUtils::get_display_errors();
            foreach ($errors as $error){
                echo "<h3>".$error['message']."</h3>";
            }
        }
        else{
            echo "<h3>User Found</h3>";
            echo "<h4>User ID: ".$searched_user['user_id']."</h4>";
            echo "<h4>Name: ".$searched_user['NAME']."</h4>";
            echo "<h4>Display Name: ".$searched_user['display_name']."</h4>";
            echo "<h4>Email ID: ".$searched_user['email']."</h4>";
            $permissions=SessionUtils::user_permissions($searched_user['user_id']);
            if($permissions){
                echo "<h4>User Permissions</h4><ul>";
                foreach($permissions as $permission){
                    echo "<li>".$permission['permission']."</li>";
                }
                echo "</ul>";
            }
        }
    }
?>
<h3>Users</h3>
<div class="users-list">
    <?php
    $users=SessionUtils::users_list();
    echo '<table>';
    echo '<tr><th>User ID</th>';
    echo '<th>User Name</th>';
    echo '<th>Display Name</th>';
    echo '<th>Email ID</th></tr>';
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>".$user['user_id']."</td>" ;
        echo "<td>".$user['NAME']."</td>";
        echo "<td>".$user['display_name']."</td>";
        echo "<td>".$user['email']."</td></tr>";
    }
    echo '</table>';
    ?>
</div>
</body>