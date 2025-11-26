<?php
// login.php
include 'includes/header.php'; 
include 'includes/db_connect.php'; 

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 1. Prepare and execute statement to retrieve user data
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // 2. Verify password
        if (password_verify($password, $user['password'])) {
            // Login successful!

            // Start session and set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // Store the user role

            // 3. CRITICAL CHANGE: Redirect based on role
            if ($user['role'] === 'admin') {
                // If admin, send them straight to the admin panel
                header("Location: admin.php");
            } else {
                // Otherwise, send them to the regular user home page
                header("Location: home.php");
            }
            exit();

        } else {
            $message = "<p style='color:red;'>Invalid username or password.</p>";
        }
    } else {
        $message = "<p style='color:red;'>Invalid username or password.</p>";
    }

    $stmt->close();
}

$conn->close();
?>

<div class="form-box">
    <h2>Login</h2>
    <?php echo $message; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p style="margin-top: 15px;">Don't have an account? <a href="signup.php">Sign up here</a>.</p>
</div>

<?php include 'includes/footer.php'; ?>