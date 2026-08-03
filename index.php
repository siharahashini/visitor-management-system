<?php
include "db.php";


$message = "";


if(isset($_POST['checkin'])){

    $visitor_id = $_POST['visitor_id'];
    $visitor_name = $_POST['visitor_name'];

    $sql = "INSERT INTO visitors(visitor_id, visitor_name, check_in)
            VALUES('$visitor_id','$visitor_name',NOW())";


    if($conn->query($sql)){
        $message = "Visitor Checked In Successfully";
    }
}



if(isset($_POST['checkout'])){

    $visitor_id = $_POST['visitor_id'];

    $sql = "UPDATE visitors 
            SET check_out=NOW(), status='Checked Out'
            WHERE visitor_id='$visitor_id' 
            AND check_out IS NULL";


    if($conn->query($sql)){
        $message = "Visitor Checked Out Successfully";
    }
}


$result = $conn->query("SELECT * FROM visitors ORDER BY id DESC");

?>


<!DOCTYPE html>
<html>

<head>

<title>Visitor Management System</title>

<link rel="stylesheet" href="style.css">

</head>


<body>


<div class="container">


<h1>🏢 Online Visitor Management System</h1>

<p>Welcome! Please check in or check out below.</p>


<h3><?php echo $message; ?></h3>


<form method="POST">


<label>Visitor ID</label>

<input type="text" name="visitor_id" required>



<label>Visitor Name</label>

<input type="text" name="visitor_name">



<button name="checkin">
✅ Check In
</button>


<button name="checkout">
🚪 Check Out
</button>


</form>



<h2>Today's Visitor Records</h2>


<table>


<tr>

<th>ID</th>
<th>Visitor ID</th>
<th>Name</th>
<th>Check In</th>
<th>Check Out</th>
<th>Status</th>

</tr>


<?php

while($row=$result->fetch_assoc()){

?>


<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['visitor_id']; ?></td>

<td><?php echo $row['visitor_name']; ?></td>

<td><?php echo $row['check_in']; ?></td>

<td><?php echo $row['check_out']; ?></td>

<td><?php echo $row['status']; ?></td>


</tr>


<?php } ?>


</table>


<br>

<a href="help.php">
<button class="help">
❓ Help
</button>
</a>


</div>


<script src="script.js"></script>

</body>

</html>