<?php
include_once('../config/db_connection.php');

if (isset($_POST['block']) && isset($_POST['maid_number'])) {
    $block = mysqli_real_escape_string($conn, $_POST['block']);
    $maid_number = mysqli_real_escape_string($conn, $_POST['maid_number']);

    $query = "SELECT flat_number FROM maids 
              WHERE block = '$block' AND maid_number = '$maid_number' 
              ORDER BY flat_number";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<option value="">Select Flat</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['flat_number'] . '">' . $row['flat_number'] . '</option>';
        }
    } else {
        echo '<option value="">No Flats Available</option>';
    }
}
