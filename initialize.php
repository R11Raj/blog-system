<?php
/**
 * Created by PhpStorm.
 * User: Raj
 * Date: 15-03-2019
 * Time: 10:54
 */
include('database.php');
define("SIGN_UP", dirname(__FILE__));
$db = db_connect();
$errors=[];
