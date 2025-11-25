<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background: #f0f2f5; }
        form { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 300px; }
        input { width: 90%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; }
        button { width: 100%; padding: 10px; background: #6c63ff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #5750d6; }
    </style>
</head>
<body>

<form action="signup-check.php" method="post">
    <h2>Sign Up</h2>
    
    <label>Name</label>
    <input type="text" name="name" placeholder="Name" required>

    <label>Email</label>
    <input type="email" name="email" placeholder="Email" required>

    <label>Password</label>
    <input type="password" name="password" placeholder="Password" required>

    <button type="submit">Sign Up</button>
    <p>Already have an account? <a href="index.php">Login here</a></p>
</form>

</body>
</html>