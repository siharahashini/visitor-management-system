<?php
/*
    config/db.php
    --------------
    This is the ONLY file where we write the database connection
    details. Every other page will "include" this file whenever it
    needs to talk to the database.
*/

// ---- change these if your XAMPP/WAMP setup is different ----
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "visitor_management";
// --------------------------------------------------------------

$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS);

if (!$conn) {
    $conn = mysqli_connect($DB_HOST, $DB_USER, "uoc");
}

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$create_db_sql = "CREATE DATABASE IF NOT EXISTS " . mysqli_real_escape_string($conn, $DB_NAME);
if (!mysqli_query($conn, $create_db_sql)) {
    die("Could not create database: " . mysqli_error($conn));
}

if (!mysqli_select_db($conn, $DB_NAME)) {
    die("Could not select database: " . mysqli_error($conn));
}

$create_users_table_sql = "
    CREATE TABLE IF NOT EXISTS Users (
        UserID INT AUTO_INCREMENT PRIMARY KEY,
        Username VARCHAR(50) NOT NULL UNIQUE,
        Password VARCHAR(255) NOT NULL,
        FullName VARCHAR(100) NOT NULL,
        Role ENUM('admin','user') NOT NULL DEFAULT 'user',
        Status ENUM('active','blocked') NOT NULL DEFAULT 'active'
    )
";

if (!mysqli_query($conn, $create_users_table_sql)) {
    die("Could not create Users table: " . mysqli_error($conn));
}

$default_user_sql = "INSERT INTO Users (Username, Password, FullName, Role, Status)
    SELECT 'uoc', 'uoc', 'Default User', 'user', 'active'
    WHERE NOT EXISTS (SELECT 1 FROM Users WHERE Username = 'uoc')";

mysqli_query($conn, $default_user_sql);
?>
