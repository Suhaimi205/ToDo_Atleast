<?php
// admin.php
include 'includes/header.php';
include 'includes/db_connect.php';

// Security Check: Only allow 'admin' role access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$message = "";

// 1. Handle User Deletion
if (isset($_GET['delete_user_id'])) {
    $delete_id = $_GET['delete_user_id'];
    
    // Prevent admin from deleting themselves!
    if ($delete_id != $_SESSION['user_id']) {
        // Delete user's tasks first (cascading delete)
        $conn->query("DELETE FROM tasks WHERE user_id = $delete_id");

        // Delete the user
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ? AND role != 'admin'"); // Add role check for safety
        $stmt->bind_param("i", $delete_id);
        
        if ($stmt->execute() && $stmt->affected_rows > 0) {
            $message = "<p style='color:green;'>User and their tasks deleted successfully.</p>";
        } else {
            $message = "<p style='color:red;'>Error deleting user or user not found.</p>";
        }
        $stmt->close();
    } else {
        $message = "<p style='color:red;'>Cannot delete your own admin account.</p>";
    }
    header("Location: admin.php"); // Refresh to show updated list
    exit();
}

// 2. Fetch all Users (excluding current admin for display safety)
$users = [];
$current_admin_id = $_SESSION['user_id'];
$result = $conn->query("SELECT id, username, email, role FROM users WHERE id != $current_admin_id ORDER BY id ASC");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

$conn->close();
?>

    <h2>🔑 Admin Management Panel</h2>
    <?php echo $message; ?>

    <h3>Manage Users</h3>
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td>
                        <a href="admin.php?delete_user_id=<?php echo $user['id']; ?>" 
                           onclick="return confirm('Are you sure you want to delete user <?php echo htmlspecialchars($user['username']); ?>? This action is irreversible.');" 
                           style="color: red; text-decoration: none;">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="5">No other users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

<?php
include 'includes/footer.php';
?>