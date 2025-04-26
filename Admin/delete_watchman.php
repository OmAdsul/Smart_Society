<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

include_once('../config/db_connection.php');


if (!isset($_GET['id'])) {
    echo "Watchman ID not provided!";
    exit;
}

$watchman_id = $_GET['id'];


$delete_sql = "DELETE FROM Watchmen WHERE watchman_id = '$watchman_id'";

if (mysqli_query($conn, $delete_sql)) {
    echo "<script>alert('Watchman deleted successfully!'); window.location.href='add_watchman.php';</script>";
} else {
    echo "<script>alert('Error deleting watchman: " . mysqli_error($conn) . "');</script>";
}
