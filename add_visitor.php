<?php
require_once 'includes/auth_check.php';
requireLogin();
require_once 'config/db.php';

$error = '';
$departmentRows = [];
$departments = mysqli_query($conn, "SELECT DepartmentID, Name FROM Departments ORDER BY Name");
while ($d = mysqli_fetch_assoc($departments)) {
    $departmentRows[] = $d;
}
$name = $nic = $phone = $email = $purpose = $host = '';
$selectedDepartment = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name']);
    $nic     = trim($_POST['nic']);
    $phone   = trim($_POST['phone']);
    $email   = trim($_POST['email']);
    $purpose = trim($_POST['purpose']);
    $host    = trim($_POST['host']);
    $dept    = (int) ($_POST['department'] ?? 0);
    $selectedDepartment = $dept;

    if ($name === '' || $nic === '' || $dept === 0) {
        $error = "Name, NIC and Department are required.";
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
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

        <label>NIC</label>
        <input type="text" name="nic" value="<?php echo htmlspecialchars($nic); ?>" required>

        <label>Phone</label>
        <input type="tel" name="phone" value="<?php echo htmlspecialchars($phone); ?>">

        <label>Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">

        <label>Purpose of Visit</label>
        <input type="text" name="purpose" value="<?php echo htmlspecialchars($purpose); ?>">

        <label>Host / Person to meet</label>
        <input type="text" name="host" value="<?php echo htmlspecialchars($host); ?>">

        <label>Department</label>
        <select name="department" required>
            <option value="">Select department</option>
            <?php foreach ($departmentRows as $d): ?>
                <option value="<?php echo $d['DepartmentID']; ?>"<?php echo ($d['DepartmentID'] === $selectedDepartment ? ' selected' : ''); ?>><?php echo htmlspecialchars($d['Name']); ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Register & Check In</button>
    </form>
</div>
<?php require_once 'includes/footer.php'; ?>
