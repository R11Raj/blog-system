<?php
require('utils/user-utils.php');
require('utils/output-utils.php');
?>
<!doctype html>
<html lang="en">
<head>
    <title>Blog Sytem-Dashboard</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"/>
</head>
<style>
    .nav-bar{
        border: 2px solid black;
        background: blueviolet;
        color: white;
    }
    table{
        border: 2px solid black;
        margin: 0px auto;
    }
    td, th {
        border: 1px solid #dddddd;
        padding: 8px;
    }
    ul{
        list-style-type: none;
    }
</style>
<body>
<nav class="nav-bar">
    <h1 class="white-text text-center">Dashboard</h1>
</nav>
<h3 class="text-center">Search User</h3>
<form action="dashboard.php" method="post" class="text-center">
    <label>Enter Display Name or Email ID</label><input type="text" required name="user_name">
    <button type="submit" class="btn btn-default">Search User</button>
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
            echo "<div class='text-center' id='".$searched_user['user_id']."'><h3>User Found</h3>";
            echo "<h4 >User ID: ".$searched_user['user_id']."</h4>";
            echo "<h4>Name: ".$searched_user['NAME']."</h4>";
            echo "<h4>Display Name: ".$searched_user['display_name']."</h4>";
            echo "<h4>Email ID: ".$searched_user['email']."</h4>";
            $permissions=SessionUtils::user_permissions($searched_user['user_id']);
            if($permissions){
                echo "<h4>User Permissions</h4><ul>";
                echo "<table>";
                foreach($permissions as $permission){
                    echo '<tr><td>';
                    echo "<li>".$permission['permission']."</td><td><a href='#'>Delete</a></td></li>";
                    echo '</tr>';
                }
                echo "</table>";
                echo "</ul>";
                echo '<h3>Add Permission</h3><select id="select-permission">';
                echo '<option value="create">Create</option>';
                echo '<option value="delete">Delete</option>';
                echo '<option value="edit">Edit</option>';
                echo '<option value="select" selected>Select</option>';
                echo '</select>';
                echo '<button id="add-permission" class="btn btn-default">Add Permission</button></div>';
            }
        }
    }
?>
<div class="text-center">
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
</div>
<script>
    function permission() {
        var permission_element=document.getElementById("select-permission");
        var user_id=this.parentElement.id;
        var permission_value = permission_element.options[permission_element.selectedIndex].value;
        if(permission_value==="select")
        {
            return false;
        }
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'add_permission.php', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if(xhr.readyState == 4 && xhr.status == 200) {
                var result = xhr.responseText;
               console.log('Result: ' + result);
            }
        };
        xhr.send("permission="+permission_value+"&user_id="+user_id);
    }

    var button = document.getElementById('add-permission');
    button.addEventListener("click", permission);

</script>
</body>