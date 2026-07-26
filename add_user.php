<?php
require_once 'includes/auth_check.php';
requireAdmin();
require_once 'config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $fullname = trim($_POST['fullname']);
    $role     = $_POST['role'];
    $status   = $_POST['status'];

    if ($username === '' || $password === '' || $fullname === '') {
        $error = "All fields are required.";
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO Users (Username, Password, FullName, Role, Status) VALUES (?,?,?,?,?)");
        mysqli_stmt_bind_param($stmt, "sssss", $username, $password, $fullname, $role, $status);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: users.php");
            exit();
        } else {
            $error = "Could not add user. Username may already exist.";
        }
    }
}

require_once 'includes/header.php';
?>

<div class="card" style="max-width:500px;">
    <h1>Add New User</h1>
    <?php if ($error): ?><p class="error"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>

    <form method="post">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="text" name="password" required>

        <label>Full Name</label>
        <input type="text" name="fullname" required>

        <label>Role</label>
        <select name="role">
            <option value="user">Ordinary User</option>
            <option value="admin">Administrator</option>
        </select>

        <label>Status</label>
        <select name="status">
            <option value="active">Active</option>
            <option value="blocked">Blocked</option>
        </select>

        <button type="submit">Add User</button>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
