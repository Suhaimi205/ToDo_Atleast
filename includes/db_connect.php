<?php
// includes/db_connect.php

$servername = "localhost";
$username = "root"; // e.g., 'root'
$password = ""; // e.g., '' for local MAMP/XAMPP
$dbname = "todo_app_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set character set to UTF8
$conn->set_charset("utf8");

// NOTE: Before running, you must create a database named 'todo_app_db' 
// and the following tables in phpMyAdmin:
// 1. users (id INT, username VARCHAR, email VARCHAR, password VARCHAR, role ENUM('user', 'admin'))
// 2. tasks (id INT, user_id INT, task_description TEXT, due_date DATE, is_completed BOOLEAN)

?>