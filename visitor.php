<?php
require_once 'includes/auth_check.php';
requireLogin();
require_once 'config/db.php';

// ---- Handle delete (?delete=ID) - admin only ----
if (isset($_GET['delete']) && isAdmin()) {
    $id = (int) $_GET['delete'];
    $stmt = mysqli_prepare($conn, "DELETE FROM Visitors WHERE VisitorID = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    header("Location: visitor.php");
    exit();
}

// ---- Search ----
$q = isset($_GET['q']) ? trim($_GET['q']) : '';

$sql = "SELECT v.*, d.Name AS DeptName FROM Visitors v
        LEFT JOIN Departments d ON v.Department = d.DepartmentID";

if ($q !== '') {
    $like = "%$q%";
    $sql .= " WHERE v.Name LIKE ? OR v.NIC LIKE ? OR v.Host LIKE ? ORDER BY v.VisitorID DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $like, $like, $like);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $sql .= " ORDER BY v.VisitorID DESC";
    $result = mysqli_query($conn, $sql);
}

require_once 'includes/header.php';
?>

<div class="card">
    <h1>Visitors</h1>

    <form method="get" style="margin-bottom:15px;">
        <label for="q">Search by name, NIC or host</label>
        <input type="text" id="q" name="q" value="<?php echo htmlspecialchars($q); ?>">
        <button type="submit">Search</button>
    </form>

    <a class="btn" href="add_visitor.php">+ Register New Visitor</a>

    <table>
        <tr>
            <th>ID</th><th>Name</th><th>NIC</th><th>Phone</th><th>Purpose</th>
            <th>Host</th><th>Department</th><th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['VisitorID']; ?></td>
            <td><?php echo htmlspecialchars($row['Name']); ?></td>
            <td><?php echo htmlspecialchars($row['NIC']); ?></td>
            <td><?php echo htmlspecialchars($row['Phone']); ?></td>
            <td><?php echo htmlspecialchars($row['Purpose']); ?></td>
            <td><?php echo htmlspecialchars($row['Host']); ?></td>
            <td><?php echo htmlspecialchars($row['DeptName']); ?></td>
            <td>
                <a class="btn btn-small" href="edit_visitor.php?id=<?php echo $row['VisitorID']; ?>">Edit</a>
                <?php if (isAdmin()): ?>
                <a class="btn btn-small btn-danger" href="visitor.php?delete=<?php echo $row['VisitorID']; ?>"
                   onclick="return confirm('Delete this visitor?');">Delete</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php require_once 'includes/footer.php'; ?>
