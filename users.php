<?php
require_once 'includes/auth_check.php';
requireAdmin();
require_once 'config/db.php';

// ---- Handle delete (?delete=ID) ----
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    // Don't allow the admin to delete themselves by accident
    if ($id !== (int) $_SESSION['user_id']) {
        $stmt = mysqli_prepare($conn, "DELETE FROM Users WHERE UserID = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
    }
    header("Location: users.php");
    exit();
}

// ---- Handle search (?q=...) ----
$q = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($q !== '') {
    $like = "%$q%";
    $stmt = mysqli_prepare($conn, "SELECT * FROM Users WHERE Username LIKE ? OR FullName LIKE ? ORDER BY UserID");
    mysqli_stmt_bind_param($stmt, "ss", $like, $like);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $result = mysqli_query($conn, "SELECT * FROM Users ORDER BY UserID");
}

require_once 'includes/header.php';
?>

<div class="card">
    <h1>Manage Users</h1>

    <form method="get" style="margin-bottom:15px;">
        <label for="q">Search by username or name</label>
        <input type="text" id="q" name="q" value="<?php echo htmlspecialchars($q); ?>">
        <button type="submit">Search</button>
    </form>

    <a class="btn" href="add_user.php">+ Add New User</a>

    <table>
        <tr>
            <th>ID</th><th>Username</th><th>Full Name</th><th>Role</th><th>Status</th><th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['UserID']; ?></td>
            <td><?php echo htmlspecialchars($row['Username']); ?></td>
            <td><?php echo htmlspecialchars($row['FullName']); ?></td>
            <td><?php echo htmlspecialchars($row['Role']); ?></td>
            <td><?php echo htmlspecialchars($row['Status']); ?></td>
            <td>
                <a class="btn btn-small" href="edit_user.php?id=<?php echo $row['UserID']; ?>">Edit</a>
                <a class="btn btn-small btn-danger" href="users.php?delete=<?php echo $row['UserID']; ?>"
                   onclick="return confirm('Delete this user?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php require_once 'includes/footer.php'; ?>
