<?php 
// Start the session here if you haven't already in the calling script
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do Dashboard</title>
    <link rel="stylesheet" href="style.css"> <style>
        /* Simple styling for the header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: #f7f7f7;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .logo { font-size: 24px; font-weight: bold; color: #6c63ff; }
        .profile-btn { 
            padding: 8px 15px; 
            border: 1px solid #ccc; 
            border-radius: 5px; 
            text-decoration: none; 
            color: #333;
        }
    </style>
</head>
<body>

    <header class="header">
        <div class="logo">TheCubeFactory</div>
        <nav>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="profile.php" class="profile-btn">Profile (<?php echo $_SESSION['username']; ?>)</a>
                <a href="logout.php" class="profile-btn" style="margin-left: 10px;">Logout</a>
            <?php else: ?>
                <a href="login.php" class="profile-btn">Login / Sign Up</a>
            <?php endif; ?>
        </nav>
    </header>
    ```

### B. The Footer File: `footer.php`

This file will contain the closing HTML tags and any site-wide footer information.

```php
    <footer>
        <div style="text-align: center; padding: 20px; border-top: 1px solid #eee; margin-top: 40px; font-size: 14px;">
            &copy; <?php echo date("Y"); ?> TheCubeFactory To Do System. All rights reserved.
        </div>
    </footer>

</body>
</html>