<?php
require_once 'includes/auth_check.php';
requireAdmin();
require_once 'config/db.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$error = '';

// ---- Handle form submission ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id       = (int) $_POST['id'];
    $fullname = trim($_POST['fullname']);
    $role     = $_POST['role'];
    $status   = $_POST['status'];

    $stmt = mysqli_prepare($conn, "UPDATE Users SET FullName=?, Role=?, Status=? WHERE UserID=?");
    mysqli_stmt_bind_param($stmt, "sssi", $fullname, $role, $status, $id);
    mysqli_stmt_execute($stmt);
    header("Location: users.php");
    exit();
}

// ---- Load current data for the form ----
$stmt = mysqli_prepare($conn, "SELECT * FROM Users WHERE UserID = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$user) {
    header("Location: users.php");
    exit();
}

require_once 'includes/header.php';
?>

<div class="card" style="max-width:500px;">
    <h1>Edit User</h1>

    <form method="post">
        <input type="hidden" name="id" value="<?php echo $user['UserID']; ?>">

        <label>Username</label>
        <input type="text" value="<?php echo htmlspecialchars($user['Username']); ?>" disabled>

        <label>Full Name</label>
        <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['FullName']); ?>" required>

        <label>Role</label>
        <select name="role">
            <option value="user"  <?php if ($user['Role']=='user')  echo 'selected'; ?>>Ordinary User</option>
            <option value="admin" <?php if ($user['Role']=='admin') echo 'selected'; ?>>Administrator</option>
        </select>

        <label>Status</label>
        <select name="status">
            <option value="active"  <?php if ($user['Status']=='active')  echo 'selected'; ?>>Active</option>
            <option value="blocked" <?php if ($user['Status']=='blocked') echo 'selected'; ?>>Blocked</option>
        </select>

        <button type="submit">Save Changes</button>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
