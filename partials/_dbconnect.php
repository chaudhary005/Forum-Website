<?php
// Script to connect to database
$servername = "localhost";
$username = "root";
$password = "";
$database = "idiscuss";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("<strong>Error ".mysqli_error()."</strong>");
}


?>