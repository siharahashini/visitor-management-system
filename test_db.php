<?php
require_once __DIR__ . '/config/db.php';

$result = mysqli_query($conn, "SELECT DATABASE() AS db");
if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo "Connected to database: " . htmlspecialchars($row['db']);
} else {
    echo "Query failed: " . mysqli_error($conn);
}

mysqli_close($conn);
?>