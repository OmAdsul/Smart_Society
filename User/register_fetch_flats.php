<?php
include_once('../config/db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['block'], $_POST['floor'])) {
    $block = mysqli_real_escape_string($conn, $_POST['block']);
    $floor = mysqli_real_escape_string($conn, $_POST['floor']);

    $query = "SELECT fa.flat_number, fa.ownership_status 
              FROM Flat_Allotment fa
              LEFT JOIN Users u ON fa.flat_number = u.flat_number AND fa.block = u.block
              WHERE fa.block='$block' AND fa.floor='$floor' 
              and fa.flat_number is not null";

    $result = mysqli_query($conn, $query);

    echo '<option value="">Select Flat</option>';
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['flat_number'] . '">' . $row['flat_number'] . ' (' . $row['ownership_status'] . ')</option>';
        }
    } else {
        echo '<option value="">No Flats Available</option>';
    }
}
