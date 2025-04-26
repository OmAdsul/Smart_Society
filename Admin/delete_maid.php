<?php
include_once('../config/db_connection.php');

if (isset($_GET['id'])) {
    $maid_number = $_GET['id'];
    $delete_query = "DELETE FROM Maids WHERE maid_number = '$maid_number'";
    if (mysqli_query($conn, $delete_query)) {
        echo "<script>alert('Maid deleted successfully!'); window.location.href='add_maid.php';</script>";
    } else {
        echo "<script>alert('Error deleting maid!');</script>";
    }
} else {
    echo "Invalid request!";
}
