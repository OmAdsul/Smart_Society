<?php
include_once('../config/db_connection.php');

if (isset($_POST['block'])) {
    $block = $_POST['block'];

    $query = "SELECT DISTINCT flat_number FROM Flat_Allotment WHERE block = '$block' ORDER BY flat_number";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<option value="">Select Flat</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . htmlspecialchars($row['flat_number']) . '">' . htmlspecialchars($row['flat_number']) . '</option>';
        }
    } else {
        echo '<option value="">No flats available</option>';
    }
}
