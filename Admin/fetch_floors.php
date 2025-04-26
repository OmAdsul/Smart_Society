<?php
include_once('../config/db_connection.php');
if (isset($_POST['block'])) {
    $block = $_POST['block'];
    $query = "SELECT DISTINCT floor FROM Flat_Allotment WHERE block='$block' ORDER BY floor";
    $result = mysqli_query($conn, $query);
    echo '<option value="">Select Floor</option>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $row['floor'] . '">' . $row['floor'] . '</option>';
    }
}
