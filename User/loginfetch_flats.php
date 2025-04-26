<?php
include_once('../config/db_connection.php');

if (isset($_POST['block']) && isset($_POST['floor'])) {
    $block = mysqli_real_escape_string($conn, $_POST['block']);
    $floor = mysqli_real_escape_string($conn, $_POST['floor']);

    $query = "SELECT flat_number FROM Flat_Allotment WHERE block = '$block' AND floor = '$floor'";

    $result = mysqli_query($conn, $query);

    echo '<option value="">Select Flat</option>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $row['flat_number'] . '">' . $row['flat_number'] . '</option>';
    }
}
