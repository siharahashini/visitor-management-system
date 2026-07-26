<?php
require_once 'includes/auth_check.php';
require_once 'includes/header.php';
?>

<div class="card">
    <h1>System Functionalities</h1>
    <ul>
        <li>User login / logout with session handling</li>
        <li>Two user roles: Administrator and Ordinary User</li>
        <li>Admin: add, edit, delete and search users</li>
        <li>Admin/User: register a new visitor (also checks them in)</li>
        <li>Edit and delete visitor records</li>
        <li>Search visitors by name, NIC or host</li>
        <li>Check visitors out (records checkout time)</li>
        <li>Daily visit report, filterable by date</li>
        <li>Monthly summary of visits per day</li>
        <li>Help page explaining how to use the system</li>
    </ul>
</div>

<?php require_once 'includes/footer.php'; ?>
