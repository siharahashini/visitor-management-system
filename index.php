<?php
require_once 'includes/auth_check.php';
require_once 'includes/header.php';

$mode = (isset($_GET['mode']) && $_GET['mode'] === 'register') ? 'register' : 'login';
$error = isset($_GET['error']) ? $_GET['error'] : '';
$success = isset($_GET['success']) ? $_GET['success'] : '';
?>

<div class="auth-page">
    <div class="auth-shell">
        <section class="auth-hero">
            <div class="auth-pill">Visitor Management System</div>
            <h1>Welcome back to the front desk.</h1>
            <p>
                Sign in to manage visitors, review reports, and keep every entry organized in one place.
            </p>

            <div class="auth-highlights">
                <div>
                    <strong>Quick access</strong>
                    <span>Fast login for daily use</span>
                </div>
                <div>
                    <strong>Safe records</strong>
                    <span>Protected user sessions</span>
                </div>
                <div>
                    <strong>Simple onboarding</strong>
                    <span>Create an account in seconds</span>
                </div>
            </div>
        </section>

        <section class="auth-card">
            <div class="auth-header">
                <span class="auth-badge"><?php echo $mode === 'register' ? 'Create account' : 'Sign in'; ?></span>
                <h2><?php echo $mode === 'register' ? 'Register' : 'Login'; ?></h2>
                <p>
                    <?php echo $mode === 'register' ? 'Create a new account to start using the system.' : 'Use your account details to continue.'; ?>
                </p>
            </div>

            <?php if ($error !== ''): ?>
                <div class="auth-alert auth-alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <?php if ($success !== ''): ?>
                <div class="auth-alert auth-alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <?php if ($mode === 'register'): ?>
                <form class="auth-form" method="post" action="login_process.php">
                    <input type="hidden" name="action" value="register">

                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" placeholder="Your full name" required>

                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Choose a username" required>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a password" required>

                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Repeat your password" required>

                    <button class="auth-button" type="submit">Create Account</button>
                </form>

                <p class="auth-switch">
                    Already have an account? <a href="index.php">Log in</a>
                </p>
            <?php else: ?>
                <form class="auth-form" method="post" action="login_process.php">
                    <input type="hidden" name="action" value="login">

                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>

                    <button class="auth-button" type="submit">Log In</button>
                </form>

                <p class="auth-switch">
                    Need an account? <a href="index.php?mode=register">Register here</a>
                </p>

                <p class="auth-note">
                    Default account: <strong>uoc / uoc</strong>
                </p>
            <?php endif; ?>
        </section>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>