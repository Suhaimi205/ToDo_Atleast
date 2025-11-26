<?php
// includes/header.php
// Start the session at the very top of every page that uses sessions
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo Atleast</title>
    <link rel="stylesheet" href="style.css"> 

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<header>
    <h1>
        <i class="fa fa-check-circle-o" style="margin-right: 10px;"></i>
        ToDo Atleast
    </h1>
    <nav>
        <?php if (isset($_SESSION['user_id'])): ?>
            
            <?php if ($_SESSION['role'] === 'user'): ?>
                <a href="home.php">My Tasks</a>
            <?php endif; ?>
            
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="admin.php">Admin Panel</a>
                
            <?php endif; ?>
            
            <a href="logout.php">Logout</a>

        <?php else: ?>
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
            <a href="signup.php">Sign Up</a>
        <?php endif; ?>
    </nav>
</header>
<main class="container">