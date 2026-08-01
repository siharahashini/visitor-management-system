<?php
/*
    login_process.php
    ------------------
    Receives the POST data from the login form on index.php,
    checks it against the Users table, and starts a session if
    the username/password match.

    We use a "prepared statement" (mysqli_prepare + bind_param) to
    safely insert the username into the SQL query. This prevents
    SQL Injection attacks. This is a core PHP/mysqli feature, not
    an external library, so it is allowed.
*/
require_once 'includes/auth_check.php';
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

$username = trim($_POST['username']);
$password = trim($_POST['password']);

// Look up the user by username only, then compare the password in PHP.
$stmt = mysqli_prepare($conn, "SELECT UserID, Username, Password, FullName, Role, Status FROM Users WHERE Username = ?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    header("Location: index.php?error=" . urlencode("No such user."));
    exit();
}

if ($user['Status'] === 'blocked') {
    header("Location: index.php?error=" . urlencode("This account has been blocked."));
    exit();
}

if ($password !== $user['Password']) {
    header("Location: index.php?error=" . urlencode("Incorrect password."));
    exit();
}

// Success! Save the important details in the session.
$_SESSION['user_id']   = $user['UserID'];
$_SESSION['username']  = $user['Username'];
$_SESSION['full_name'] = $user['FullName'];
$_SESSION['role']      = $user['Role'];

header("Location: home.php");
exit();
?>
