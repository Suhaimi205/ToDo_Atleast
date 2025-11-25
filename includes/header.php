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
    <title>To Do List App</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

<header>
    <h1>To Do App</h1>
    <nav>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="home.php">My Tasks</a>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="admin.php">Admin Panel</a>
            <?php endif; ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="index.php">home</a>
            <a href="login.php">Login</a>
            <a href="signup.php">Sign Up</a>
        <?php endif; ?>
    </nav>
</header>
<main class="container">