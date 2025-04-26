<?php
include_once('../config/db_connection.php');

if (isset($_POST['block']) && isset($_POST['floor']) && isset($_POST['flat_type'])) {
    $block = $_POST['block'];
    $floor = $_POST['floor'];
    $flat_type = $_POST['flat_type'];


    $query = "SELECT flat_number FROM Flat_Details 
              WHERE block = '$block' AND floor = '$floor' AND flat_type = '$flat_type' 
              AND flat_number NOT IN (SELECT flat_number FROM Flat_Allotment)";

    $result = mysqli_query($conn, $query);

    echo "<option value=''>Select Flat</option>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . $row['flat_number'] . "'>" . $row['flat_number'] . "</option>";
    }
}
