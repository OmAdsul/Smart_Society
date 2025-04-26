<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

include_once('../config/db_connection.php');
$admin_username = $_SESSION['admin_username'];

$floors = [];
$flats = [];

if (!empty($_GET['block'])) {
    $block = $_GET['block'];

    $query = "SELECT DISTINCT floor FROM Flat_Allotment WHERE block='$block' ORDER BY floor";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $floors[] = $row['floor'];
    }

    if (!empty($_GET['floor'])) {
        $floor = $_GET['floor'];
        $query = "SELECT flat_number FROM Flat_Allotment WHERE block='$block' AND floor='$floor' ORDER BY flat_number";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $flats[] = $row['flat_number'];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $block = mysqli_real_escape_string($conn, $_POST['block']);
    $floor = mysqli_real_escape_string($conn, $_POST['floor']);
    $flat_number = mysqli_real_escape_string($conn, $_POST['flat_number']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);

    $checkFlat = mysqli_query($conn, "SELECT * FROM Flat_Allotment WHERE flat_number='$flat_number' AND block='$block' AND floor='$floor'");
    if (mysqli_num_rows($checkFlat) == 0) {
        echo "<script>alert('Error: The selected block, floor, and flat do not match any allotted flats.');</script>";
    } else {
        $sql = "INSERT INTO Penalties (flat_number, block, amount, reason, date_imposed, status, date_solved) 
                VALUES ('$flat_number', '$block', '$amount', '$reason', CURDATE(), 'Unpaid', NULL)";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Penalty added successfully.');</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }
}


$penaltyQuery = "SELECT * FROM Penalties order by date_imposed desc";
$penaltyResult = mysqli_query($conn, $penaltyQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Penalty</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function fetchFloors() {
            var block = document.getElementById("block").value;
            if (block) {
                window.location.href = "add_penalty.php?block=" + block;
            }
        }

        function fetchFlats() {
            var block = document.getElementById("block").value;
            var floor = document.getElementById("floor").value;
            if (block && floor) {
                window.location.href = "add_penalty.php?block=" + block + "&floor=" + floor;
            }
        }

        $(document).ready(function() {
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#penalty-table tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #2c3e50;
            padding: 15px;
            position: sticky;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .navbar-brand {
            color: #ffffff !important;
            font-weight: 500;
            font-size: 22px;
        }

        .navbar-text {
            color: #ffffff;
            font-weight: 400;
            font-size: 16px;
        }

        .container {
            margin-left: 260px;
            padding: 20px;
            width: calc(100% - 300px);
            color: #2c3e50;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: white;
            padding: 20px;
            margin: 20px;
            color: #2c3e50;
        }

        .btn-primary {
            background-color: #ff6f61;
            border: none;
        }

        .btn-primary:hover {
            background-color: #e05a47;
        }

        .sidebar {
            position: fixed;
            left: 0;
            height: 100vh;
            width: 250px;
            background: #2c3e50;
            padding-top: 20px;
            overflow-y: auto;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            width: 100%;
        }

        .sidebar ul li a {
            display: block;
            padding: 12px 20px;
            color: #ffffff;
            text-decoration: none;
            font-size: 16px;
            font-weight: 400;
            transition: background 0.3s ease;
        }

        .sidebar ul li a:hover,
        .sidebar ul li a.active {
            background-color: #ff6f61;
            font-weight: 500;
        }

        table {
            width: 100%;
            margin-top: 20px;
            background: white;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
            text-align: center;
        }

        th,
        td {
            padding: 10px;
        }

        th {
            background-color: #ff6f61;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>




<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Smart Society</a>
            <span class="navbar-text ms-auto me-3">Welcome, <?php echo htmlspecialchars($admin_username); ?></span>
            <a href="admin_logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </nav>

    <div class="sidebar">
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="add_allotment.php">Manage Flats</a></li>
            <li><a href="update_flat_details.php">Update Flat Details</a></li>
            <li><a href="add_notice.php">Add Notice</a></li>
            <li><a href="view_complaints.php">View Complaints</a></li>
            <li><a href="add_watchman.php">Manage Watchmen</a></li>
            <li><a class="active" href="add_penalty.php">Manage Penalty</a></li>
            <li><a href="add_maid.php">Maid Allotment</a></li>
            <li><a href="view_maintenance.php">View Maintenance Records</a></li>
        </ul>
    </div>

    <div class="container">
        <div class="card">
            <h2 class="text-center">Add Penalty</h2>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Block:</label>
                    <select name="block" id="block" class="form-control" required onchange="fetchFloors()">
                        <option value="">Select Block</option>
                        <option value="A" <?= isset($_GET['block']) && $_GET['block'] == 'A' ? 'selected' : '' ?>>A</option>
                        <option value="B" <?= isset($_GET['block']) && $_GET['block'] == 'B' ? 'selected' : '' ?>>B</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Floor:</label>
                    <select name="floor" id="floor" class="form-control" required onchange="fetchFlats()">
                        <option value="">Select Floor</option>
                        <?php foreach ($floors as $floor) { ?>
                            <option value="<?= $floor ?>" <?= isset($_GET['floor']) && $_GET['floor'] == $floor ? 'selected' : '' ?>>
                                <?= "Floor " . $floor ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Flat Number:</label>
                    <select name="flat_number" id="flat_number" class="form-control" required>
                        <option value="">Select Flat</option>
                        <?php foreach ($flats as $flat) { ?>
                            <option value="<?= $flat ?>"><?= "Flat " . $flat ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Penalty Amount:</label>
                    <input type="number" step="0.01" name="amount" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Reason:</label>
                    <textarea name="reason" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Impose Penalty</button>
            </form>
        </div>
        <h4>Penalty details</h4>
        <input type="text" id="search" class="form-control mb-3" placeholder="Search penalties...">
        <table id="penalty-table">
            <tr>
                <th>Block</th>
                <th>Flat Number</th>
                <th>Amount</th>
                <th>Reason</th>
                <th>Date Imposed</th>
                <th>Status</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($penaltyResult)) { ?>
                <tr>
                    <td><?= $row['block'] ?></td>
                    <td><?= $row['flat_number'] ?></td>
                    <td><?= $row['amount'] ?></td>
                    <td><?= $row['reason'] ?></td>
                    <td><?= date('Y-m-d', strtotime($row['date_imposed'])) ?></td>
                    <td><?= $row['status'] ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>

</html>