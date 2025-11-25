<?php
$sname = "localhost";
$uname = "root";
$password = ""; // Default XAMPP password is empty
$db_name = "todo_system";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>