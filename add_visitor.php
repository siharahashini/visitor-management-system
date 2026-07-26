<?php
require_once 'includes/auth_check.php';
requireLogin();
require_once 'config/db.php';

$error = '';
$departments = mysqli_query($conn, "SELECT * FROM Departments ORDER BY Name");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name']);
    $nic     = trim($_POST['nic']);
    $phone   = trim($_POST['phone']);
    $email   = trim($_POST['email']);
    $purpose = trim($_POST['purpose']);
    $host    = trim($_POST['host']);
    $dept    = (int) $_POST['department'];

    if ($name === '' || $nic === '') {
        $error = "Name and NIC are required.";
    } else {
        // 1) Insert into Visitors
        $stmt = mysqli_prepare($conn,
            "INSERT INTO Visitors (Name, NIC, Phone, Email, Purpose, Host, Department) VALUES (?,?,?,?,?,?,?)");
        mysqli_stmt_bind_param($stmt, "ssssssi", $name, $nic, $phone, $email, $purpose, $host, $dept);
        mysqli_stmt_execute($stmt);
        $visitorId = mysqli_insert_id($conn);

        // 2) Automatically create a Visit record = check the visitor in now
        $today = date('Y-m-d');
        $now   = date('H:i:s');
        $stmt2 = mysqli_prepare($conn,
            "INSERT INTO Visits (VisitorID, CheckIn, Date, Status) VALUES (?,?,?, 'checked-in')");
        mysqli_stmt_bind_param($stmt2, "iss", $visitorId, $now, $today);
        mysqli_stmt_execute($stmt2);

        header("Location: visitor.php");
        exit();
    }
}

require_once 'includes/header.php';
?>

<div class="card" style="max-width:520px;">
    <h1>Register Visitor</h1>
    <?php if ($error): ?><p class="error"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>

    <form method="post">
        <label>Full Name</label>
        <input type="text" name="name" required>

        <label>NIC</label>
        <input type="text" name="nic" required>

        <label>Phone</label>
        <input type="tel" name="phone">

        <label>Email</label>
        <input type="email" name="email">

        <label>Purpose of Visit</label>
        <input type="text" name="purpose">

        <label>Host / Person to meet</label>
        <input type="text" name="host">

        <label>Department</label>
        <select name="department">
            <?php while ($d = mysqli_fetch_assoc($departments)): ?>
                <option value="<?php echo $d['DepartmentID']; ?>"><?php echo htmlspecialchars($d['Name']); ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Register & Check In</button>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
