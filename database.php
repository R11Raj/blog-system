<?php
/**
 * Created by PhpStorm.
 * User: Raj
 * Date: 15-03-2019
 * Time: 12:16
 */
require('dbcredentials.php');
function db_connect() {
    try {
    $connection = new PDO("mysql:host=localhost;dbname=blog_system", DB_USER, DB_PASS);
    // set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    //confirm_db_connect();
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    return $connection;
}
function db_disconnect($connection) {
    if(isset($connection)) {
        mysqli_close($connection);
    }
}

function confirm_db_connect() {
    if(mysqli_connect_errno()) {
        $msg = "Database connection failed: ";
        $msg .= mysqli_connect_error();
        $msg .= " (" . mysqli_connect_errno() . ")";
        exit($msg);
    }
}
?>