<?php
include_once('../config/db_connection.php');

if (isset($_POST['maid_number'])) {
    $maid_number = $_POST['maid_number'];
    $maid_query = "SELECT name FROM Maids WHERE maid_number='$maid_number'";
    $maid_result = mysqli_query($conn, $maid_query);
    $maid = mysqli_fetch_assoc($maid_result);

    if ($maid) {
        echo json_encode(["success" => true, "maid_name" => $maid['name']]);
    } else {
        echo json_encode(["success" => false, "message" => "Maid not found"]);
    }
}
