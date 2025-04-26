<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

include_once('../config/db_connection.php');


$month_year = date('Y-m');


$check_query = "SELECT * FROM Maintenance WHERE month_year = '$month_year'";
$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) > 0) {
    echo "<script>alert('Maintenance for this month is already generated.'); window.location.href='admin_dashboard.php';</script>";
    exit;
}


$flat_query = "SELECT block, flat_number, flat_type FROM Flat_Allotment";
$flat_result = mysqli_query($conn, $flat_query);

while ($row = mysqli_fetch_assoc($flat_result)) {
    $block = $row['block'];
    $flat_number = $row['flat_number'];
    $flat_type = $row['flat_type'];


    $amount = ($flat_type == '1BHK') ? 5000 : (($flat_type == '2BHK') ? 7000 : 9000);

    $insert_query = "INSERT INTO Maintenance (month_year, block, flat_number, flat_type, amount) 
                     VALUES ('$month_year', '$block', '$flat_number', '$flat_type', '$amount')";
    mysqli_query($conn, $insert_query);
}

echo "<script>alert('Maintenance generated successfully!'); window.location.href='admin_dashboard.php';</script>";
