<?php
include_once('../config/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $contact_number = $_POST['contact_number'];
    $block = $_POST['block'];
    $floor = $_POST['floor'];
    $flat_type = $_POST['flat_type'];
    $flat_number = $_POST['flat_number'];
    $maintenance_charge = $_POST['maintenance_charge'];
    $total_members = $_POST['total_members'];
    $members_names = $_POST['members'] ?? [];

    $members_list = implode(", ", $members_names);

    $query = "INSERT INTO Flat_Allotment (name, contact_number, block, floor, flat_type, flat_number, maintenance_charge, total_members, members_names)
              VALUES ('$name', '$contact_number', '$block', '$floor', '$flat_type', '$flat_number', '$maintenance_charge', '$total_members', '$members_list')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Flat allotted successfully!'); window.location.href='add_allotment.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
