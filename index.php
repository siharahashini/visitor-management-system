<?php
/*
    index.php
    ---------
    This is the FIRST page a user sees (as required by the spec).
    If someone is already logged in, we send them straight to
    home.php instead of showing the login form again.
*/
require_once 'includes/auth_check.php';

if (isLoggedIn()) {
    header("Location: home.php");
    exit();
}

// If login_process.php sent us back here with an error or success message, show it
$error = isset($_GET['error']) ? $_GET['error'] : '';
$success = isset($_GET['success']) ? $_GET['success'] : '';

require_once 'includes/header.php';
?>

<div class="card" style="max-width:420px; margin:40px auto;">
    <h1>Login</h1>

    <?php if ($error): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color:green; font-weight:bold;">
            <?php echo htmlspecialchars($success); ?>
        </p>
    <?php endif; ?>

    <form action="login_process.php" method="post">
        <input type="hidden" name="action" value="login">

        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>

    <hr style="margin:20px 0;">

    <h2 style="margin-bottom:10px; font-size:1.1em;">Create Account</h2>
    <form action="login_process.php" method="post">
        <input type="hidden" name="action" value="register">

        <label for="reg_username">Username</label>
        <input type="text" id="reg_username" name="username" required>

        <label for="reg_password">Password</label>
        <input type="password" id="reg_password" name="password" required>

        <label for="confirm_password">Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit">Create Account</button>
    </form>


</div>

<?php require_once 'includes/footer.php'; ?>