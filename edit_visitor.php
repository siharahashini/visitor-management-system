<?php
require_once 'includes/auth_check.php';
requireLogin();
require_once 'config/db.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$departments = mysqli_query($conn, "SELECT * FROM Departments ORDER BY Name");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id      = (int) $_POST['id'];
    $name    = trim($_POST['name']);
    $nic     = trim($_POST['nic']);
    $phone   = trim($_POST['phone']);
    $email   = trim($_POST['email']);
    $purpose = trim($_POST['purpose']);
    $host    = trim($_POST['host']);
    $dept    = (int) $_POST['department'];

    $stmt = mysqli_prepare($conn,
        "UPDATE Visitors SET Name=?, NIC=?, Phone=?, Email=?, Purpose=?, Host=?, Department=? WHERE VisitorID=?");
    mysqli_stmt_bind_param($stmt, "ssssssii", $name, $nic, $phone, $email, $purpose, $host, $dept, $id);
    mysqli_stmt_execute($stmt);
    header("Location: visitor.php");
    exit();
}

$stmt = mysqli_prepare($conn, "SELECT * FROM Visitors WHERE VisitorID = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$v = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$v) {
    header("Location: visitor.php");
    exit();
}

require_once 'includes/header.php';
?>

<div class="card" style="max-width:520px;">
    <h1>Edit Visitor</h1>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $v['VisitorID']; ?>">

        <label>Full Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($v['Name']); ?>" required>

        <label>NIC</label>
        <input type="text" name="nic" value="<?php echo htmlspecialchars($v['NIC']); ?>" required>

        <label>Phone</label>
        <input type="tel" name="phone" value="<?php echo htmlspecialchars($v['Phone']); ?>">

        <label>Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($v['Email']); ?>">

        <label>Purpose of Visit</label>
        <input type="text" name="purpose" value="<?php echo htmlspecialchars($v['Purpose']); ?>">

        <label>Host / Person to meet</label>
        <input type="text" name="host" value="<?php echo htmlspecialchars($v['Host']); ?>">

        <label>Department</label>
        <select name="department">
            <?php while ($d = mysqli_fetch_assoc($departments)): ?>
                <option value="<?php echo $d['DepartmentID']; ?>"
                    <?php if ($d['DepartmentID'] == $v['Department']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($d['Name']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Save Changes</button>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>