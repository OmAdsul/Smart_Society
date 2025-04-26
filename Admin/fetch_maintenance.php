<?php
if (isset($_POST['flat_type'])) {
    $flat_type = $_POST['flat_type'];
    $maintenanceCharges = [
        "1BHK" => 5000,
        "2BHK" => 7000,
        "3BHK" => 9000
    ];
    echo $maintenanceCharges[$flat_type] ?? "";
}
