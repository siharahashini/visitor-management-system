<?php
/*
    includes/header.php
    --------------------
    Shared top navigation bar. It checks the session and shows
    different links depending on whether someone is logged in,
    and whether they are an admin.
    IMPORTANT: auth_check.php must already be included by the page
    before this file, so $_SESSION is available here.
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Visitor Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="topbar">
    <div class="brand">Visitor Management System</div>
    <nav>
        <a href="home.php">Home</a>
        <a href="functionalities.php">Functionalities</a>
        <a href="help.php">Help</a>
        <?php if (isLoggedIn()): ?>
            <a href="visitor.php">Visitors</a>
            <?php if (isAdmin()): ?>
                <a href="admin.php">Admin</a>
            <?php endif; ?>
            <span class="welcome">Hi, <?php echo htmlspecialchars($_SESSION['full_name']); ?></span>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="index.php">Login</a>
        <?php endif; ?>
    </nav>
</header>
<main class="content">
