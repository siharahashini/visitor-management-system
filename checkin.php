<?php
include "dp.php";

// Check In
if(isset($_POST['checkin'])){

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $purpose = $_POST['purpose'];

    $sql = "INSERT INTO visitors(name, phone, purpose)
            VALUES('$name','$phone','$purpose')";

    if(mysqli_query($conn,$sql)){
        echo "Visitor Checked In Successfully";
    }
    else{
        echo "Error: ".mysqli_error($conn);
    }
}


// Check Out
if(isset($_POST['checkout'])){

    $id = $_POST['id'];

    $sql = "UPDATE visitors 
            SET check_out = NOW()
            WHERE id='$id'";

    if(mysqli_query($conn,$sql)){
        echo "Visitor Checked Out Successfully";
    }
    else{
        echo "Error: ".mysqli_error($conn);
    }
}

?>


<!DOCTYPE html>
<html>
<head>
<title>Visitor Check In / Check Out</title>
</head>

<body>

<h2>Visitor Check In</h2>

<form method="POST">

Name:
<input type="text" name="name" required>
<br><br>

Phone:
<input type="text" name="phone" required>
<br><br>

Purpose:
<input type="text" name="purpose" required>
<br><br>

<button type="submit" name="checkin">
Check In
</button>

</form>


<hr>


<h2>Visitor Check Out</h2>

<form method="POST">

Visitor ID:
<input type="number" name="id" required>

<br><br>

<button type="submit" name="checkout">
Check Out
</button>

</form>


</body>
</html>