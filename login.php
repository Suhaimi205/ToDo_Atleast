<?php
// login.php
include 'includes/header.php';
include 'includes/db_connect.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verify the hashed password
        if (password_verify($password, $user['password'])) {
            // Login successful: Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // Redirect to home page
            header("Location: home.php");
            exit();
        } else {
            $message = "<p style='color:red;'>Invalid email or password.</p>";
        }
    } else {
        $message = "<p style='color:red;'>Invalid email or password.</p>";
    }
    $stmt->close();
}

$conn->close();
?>
    <div class="form-box">
        <h3>User Login</h3>
        <?php echo $message; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Sign Up here</a>.</p>
    </div>

<?php
include 'includes/footer.php';
?>