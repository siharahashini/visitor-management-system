<?php
require_once 'includes/auth_check.php';
require_once 'includes/header.php';
?>

<div class="card">
    <h1>Help</h1>

    <h3>1. Logging in</h3>
    <p>Go to the Login page and enter your username and password. If you don't have an
       account, use the default account <strong>uoc / uoc</strong>. Administrators can
       log in with <strong>admin / admin123</strong>.</p>

    <h3>2. Registering a visitor</h3>
    <p>Go to <em>Visitors → + Register New Visitor</em>, fill in the visitor's details and
       submit. The visitor is automatically checked in with the current time.</p>

    <h3>3. Checking a visitor out</h3>
    <p>Go to <em>Visit Reports</em>, find the visitor in today's list, and click
       <em>Check Out</em>.</p>

    <h3>4. Viewing reports</h3>
    <p>The Reports page shows all visits for a chosen date, plus a monthly summary of
       how many visits happened each day.</p>

    <h3>5. Admin tasks</h3>
    <p>Administrators can add, edit, delete and search user accounts from the
       Admin Dashboard, and can also delete visitor records.</p>
</div>

<?php require_once 'includes/footer.php'; ?>