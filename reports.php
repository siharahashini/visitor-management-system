<?php
require_once 'includes/auth_check.php';
requireLogin();
require_once 'config/db.php';

// ---- Handle "Check Out" button ----
if (isset($_GET['checkout'])) {
    $visitId = (int) $_GET['checkout'];
    $now = date('H:i:s');
    $stmt = mysqli_prepare($conn, "UPDATE Visits SET CheckOut = ?, Status = 'checked-out' WHERE VisitID = ?");
    mysqli_stmt_bind_param($stmt, "si", $now, $visitId);
    mysqli_stmt_execute($stmt);
    header("Location: reports.php");
    exit();
}

// ---- Filter by date (defaults to today) ----
$date = isset($_GET['date']) && $_GET['date'] !== '' ? $_GET['date'] : date('Y-m-d');

$sql = "SELECT vi.*, vr.Name, vr.NIC, vr.Host
        FROM Visits vi
        JOIN Visitors vr ON vi.VisitorID = vr.VisitorID
        WHERE vi.Date = ?
        ORDER BY vi.VisitID DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $date);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// ---- Monthly summary count (visits per day, current month) ----
$monthSql = "SELECT Date, COUNT(*) AS Total FROM Visits
             WHERE MONTH(Date) = MONTH(CURDATE()) AND YEAR(Date) = YEAR(CURDATE())
             GROUP BY Date ORDER BY Date DESC";
$monthResult = mysqli_query($conn, $monthSql);

require_once 'includes/header.php';
?>

<div class="card">
    <h1>Visit Reports</h1>

    <form method="get" style="margin-bottom:15px;">
        <label for="date">Show visits for date</label>
        <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($date); ?>">
        <button type="submit">Filter</button>
    </form>

    <table>
        <tr>
            <th>Visit ID</th><th>Visitor</th><th>NIC</th><th>Host</th>
            <th>Check In</th><th>Check Out</th><th>Status</th><th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['VisitID']; ?></td>
            <td><?php echo htmlspecialchars($row['Name']); ?></td>
            <td><?php echo htmlspecialchars($row['NIC']); ?></td>
            <td><?php echo htmlspecialchars($row['Host']); ?></td>
            <td><?php echo htmlspecialchars($row['CheckIn']); ?></td>
            <td><?php echo $row['CheckOut'] ? htmlspecialchars($row['CheckOut']) : '-'; ?></td>
            <td><?php echo htmlspecialchars($row['Status']); ?></td>
            <td>
                <?php if ($row['Status'] === 'checked-in'): ?>
                    <a class="btn btn-small" href="reports.php?checkout=<?php echo $row['VisitID']; ?>">Check Out</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<div class="card">
    <h2>Monthly Summary (visits per day)</h2>
    <table>
        <tr><th>Date</th><th>Total Visits</th></tr>
        <?php while ($m = mysqli_fetch_assoc($monthResult)): ?>
        <tr>
            <td><?php echo htmlspecialchars($m['Date']); ?></td>
            <td><?php echo $m['Total']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php require_once 'includes/footer.php'; ?>
