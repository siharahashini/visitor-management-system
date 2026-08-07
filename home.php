<?php
require_once 'includes/auth_check.php';
require_once 'includes/header.php';
?>

<?php if (isLoggedIn()): ?>
    <div class="card">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h1>
        <p>You are logged in as <strong><?php echo htmlspecialchars($_SESSION['role']); ?></strong>.</p>
    </div>

    <div class="tiles">
        <a class="tile" href="visitor.php">Register / View Visitors</a>
        <?php if (isAdmin()): ?>
            <a class="tile" href="reports.php">Visit Reports</a>
            <a class="tile" href="admin.php">Admin Dashboard</a>
        <?php endif; ?>
        <a class="tile" href="functionalities.php">All Functionalities</a>
        <a class="tile" href="help.php">Help</a>
    </div>
<?php else: ?>
    <!-- Default page shown to people who have not logged in -->
    <div class="card">
        <h1>Welcome to the Online Visitor Management System</h1>
        <p>This system lets an organization register, track, and report on visitors
           entering the building.</p>
        <p>Please <a href="index.php">login</a> to continue.
           You can use the default account <strong>uoc / uoc</strong> to try it out.</p>
    </div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>