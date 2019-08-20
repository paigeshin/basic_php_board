<?php
$serverName = "localhost";
$dbUser = "root";
$dbPassword = "123123";
$db = "php_board";

$connection = mysqli_connect($serverName, $dbUser, $dbPassword, $db);

if(!$connection)
{
    die("Connection failed: " . mysqli_connect_error());
}


?>