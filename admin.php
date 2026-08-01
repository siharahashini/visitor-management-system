<?php
require_once 'includes/auth_check.php';
requireAdmin();
require_once 'includes/header.php';
?>

<div class="card">
    <h1>Admin Dashboard</h1>
    <p>All administrative tasks are available from here.</p>
</div>

<div class="tiles">
    <a class="tile" href="users.php">Manage Users</a>
    <a class="tile" href="add_user.php">Add New User</a>
    <a class="tile" href="visitor.php">Manage Visitors</a>
    <a class="tile" href="reports.php">Reports</a>
</div>

<?php require_once 'includes/footer.php'; ?>