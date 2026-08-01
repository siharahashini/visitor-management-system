?php
/*
    includes/auth_check.php
    ------------------------
    Small helper functions for login checking. Every protected page
    starts by including this file and then calling requireLogin()
    or requireAdmin().

    session_start() must run before ANY HTML is sent to the browser,
    which is why it is the very first thing here.
*/

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Is anybody logged in right now?
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Is the logged-in person an admin?
function isAdmin() {
    return isLoggedIn() && $_SESSION['role'] === 'admin';
}

// Call this at the top of pages that ANY logged-in user may see
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: index.php");
        exit();
    }
}

// Call this at the top of pages that ONLY admins may see
function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        echo "<h2>Access denied. Admins only.</h2>";
        echo "<p><a href='home.php'>Back to Home</a></p>";
        exit();
    }
}
?>