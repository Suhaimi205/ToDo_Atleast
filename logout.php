<?php
// logout.php

// 1. Start the session to access session variables
session_start();

// 2. Unset all session variables
$_SESSION = array();

// 3. Destroy the session
session_destroy();

// 4. Redirect the user to the landing page or login page
header("Location: index.php"); 
exit();
?>