<?php
require_once 'includes/auth_check.php';
session_unset();
session_destroy();
header("Location: index.php");
exit();
?>
