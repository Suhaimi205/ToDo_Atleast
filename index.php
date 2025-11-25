<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ToDo System</title>
    <style>
        /* Simple CSS to match the clean look of your reference image */
        body {
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }
        .login-container {
            background: white;
            width: 350px;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
            font-size: 14px;
        }
        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; /* Ensures padding doesn't widen the box */
        }
        button {
            width: 100%;
            padding: 12px;
            background: #6c63ff; /* Purple shade from your image */
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background: #5750d6;
        }
        .error {
            background: #F2DEDE;
            color: #A94442;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
            text-align: center;
            font-size: 14px;
        }
        .footer-link {
            margin-top: 15px;
            text-align: center;
            font-size: 14px;
        }
        .footer-link a {
            color: #6c63ff;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <form action="login.php" method="post">
            <h2>Welcome Back</h2>

            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>

            <label>User Name</label>
            <input type="text" name="uname" placeholder="Enter your username">

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password">

            <button type="submit">Sign in</button>

            <div class="footer-link">
                <p>Don't have an account? <a href="signup.php">Sign up</a></p>
            </div>
        </form>
    </div>

</body>
</html>