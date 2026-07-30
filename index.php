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

// If login_process.php sent us back here with an error or success message, show it.
$error = isset($_GET['error']) ? $_GET['error'] : '';
$success = isset($_GET['success']) ? $_GET['success'] : '';
$mode = isset($_GET['mode']) && $_GET['mode'] === 'register' ? 'register' : 'login';

require_once 'includes/header.php';
?>

<section class="auth-page">
    <div class="auth-hero">
        <p class="eyebrow">Secure Visitor Access</p>
        <h1>Welcome Back</h1>
        <p>Manage visitor records, check-ins, reports, and users from one clean dashboard.</p>
        <div class="auth-highlights">
            <span>Fast check-in</span>
            <span>Visitor reports</span>
            <span>Admin control</span>
        </div>
    </div>

    <div class="auth-card">
        <div id="loginForm" class="auth-panel <?php echo $mode === 'login' ? 'active' : ''; ?>">
            <div class="auth-heading">
                <p class="eyebrow">Account Login</p>
                <h2>Sign in to VMS</h2>
            </div>

            <?php if ($error && $mode === 'login'): ?>
                <p class="message error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <?php if ($success): ?>
                <p class="message success"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>

            <form action="login_process.php" method="post" class="auth-form">
                <input type="hidden" name="action" value="login">

                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>

                <button type="submit">Login</button>
            </form>

            <p class="auth-switch">
                Don't have an account?
                <a href="?mode=register" data-show-register>Create new</a>
            </p>
        </div>

        <div id="registerForm" class="auth-panel <?php echo $mode === 'register' ? 'active' : ''; ?>">
            <div class="auth-heading">
                <p class="eyebrow">New Account</p>
                <h2>Create your account</h2>
            </div>

            <?php if ($error && $mode === 'register'): ?>
                <p class="message error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <form action="login_process.php" method="post" class="auth-form">
                <input type="hidden" name="action" value="register">

                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" required>

                <label for="reg_username">Username</label>
                <input type="text" id="reg_username" name="username" placeholder="Choose a username" required>

                <label for="reg_password">Password</label>
                <input type="password" id="reg_password" name="password" placeholder="Create a password" required>

                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter password" required>

                <button type="submit">Create Account</button>
            </form>

            <p class="auth-switch">
                Already have an account?
                <a href="?mode=login" data-show-login>Login here</a>
            </p>
        </div>
    </div>
</section>

<script>
    const loginPanel = document.getElementById('loginForm');
    const registerPanel = document.getElementById('registerForm');

    document.querySelector('[data-show-register]').addEventListener('click', function (event) {
        event.preventDefault();
        loginPanel.classList.remove('active');
        registerPanel.classList.add('active');
        history.replaceState(null, '', '?mode=register');
    });

    document.querySelector('[data-show-login]').addEventListener('click', function (event) {
        event.preventDefault();
        registerPanel.classList.remove('active');
        loginPanel.classList.add('active');
        history.replaceState(null, '', '?mode=login');
    });
</script>

<?php require_once 'includes/footer.php'; ?>
