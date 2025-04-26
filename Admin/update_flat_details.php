<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

include_once('../config/db_connection.php');

$admin_username = $_SESSION['admin_username'];

$owned_flats = [];
if (!empty($_GET['block']) && !empty($_GET['floor'])) {
    $block = $_GET['block'];
    $floor = $_GET['floor'];

    $query = "SELECT flat_number FROM Flat_Allotment WHERE block='$block' AND floor='$floor' AND ownership_status='owned'";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $owned_flats[] = $row['flat_number'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rent_flat'])) {
    $name = trim($_POST["name"]);
    $contact_number = trim($_POST["contact_number"]);
    $email = trim($_POST["email"]);
    $block = trim($_POST["block"]);
    $floor = trim($_POST["floor"]);
    $flat_number = trim($_POST["flat_number"]);
    $total_members = (int) $_POST["total_members"];
    $members_names = trim($_POST["members_names"]);

    $checkFlat = "SELECT * FROM Flat_Allotment WHERE flat_number = ? AND ownership_status = 'owned'";
    $stmt = mysqli_prepare($conn, $checkFlat);
    mysqli_stmt_bind_param($stmt, "s", $flat_number);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        echo "<script>alert('Error: Selected flat is not available for rent!');</script>";
    } else {
        $insertQuery = "INSERT INTO rented_flats (flat_number, name, email, contact_number, block, total_members, members_names) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($stmt, "sssssis", $flat_number, $name, $email, $contact_number, $block, $total_members, $members_names);

        if (mysqli_stmt_execute($stmt)) {
            $updateQuery = "UPDATE Flat_Allotment SET ownership_status = 'rented' WHERE flat_number = ?";
            $stmt = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($stmt, "s", $flat_number);
            mysqli_stmt_execute($stmt);

            echo "<script>alert('Flat rented successfully!'); window.location.href='update_flat_details.php';</script>";
        } else {
            echo "<script>alert('Error: Could not update flat details!');</script>";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $flat_number = $_POST['flat_number'];

    $updateQuery = "UPDATE Flat_Allotment SET ownership_status = 'owned' WHERE flat_number = ?";
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, "s", $flat_number);

    if (mysqli_stmt_execute($stmt)) {
        $deleteQuery = "DELETE FROM rented_flats WHERE flat_number = ?";
        $stmt = mysqli_prepare($conn, $deleteQuery);
        mysqli_stmt_bind_param($stmt, "s", $flat_number);
        mysqli_stmt_execute($stmt);

        echo "<script>alert('Flat status updated to owned!'); window.location.href='update_flat_details.php';</script>";
    } else {
        echo "<script>alert('Error: Could not update flat status!');</script>";
    }
}

$rented_flats_query = "SELECT * FROM rented_flats";
$rented_flats_result = mysqli_query($conn, $rented_flats_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Update Flat Details</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #2c3e50;
            position: fixed;
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

        .main-content {
            flex-grow: 1;
            margin-left: 260px;
            padding: 20px;
            color: #2c3e50;
        }

        .card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: #2c3e50;
        }

        .table th {
            background: #ff6f61;
            color: white;
            text-align: center;
        }

        .table td {
            text-align: center;
            color: #2c3e50;
        }

        .form-control {
            border-radius: 5px;
            padding: 10px;
        }

        .btn-primary {
            background-color: #ff6f61;
            border: none;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
        }
    </style>

    <script>
        function fetchFlats() {
            var block = document.getElementById("block").value;
            var floor = document.getElementById("floor").value;

            if (block && floor) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "../user/register_fetch_flats.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        document.getElementById("flat_number").innerHTML = xhr.responseText;
                    }
                };

                xhr.send("block=" + block + "&floor=" + floor);
            } else {
                document.getElementById("flat_number").innerHTML = "<option value=''>Select Flat</option>";
            }

            $("#total_members").change(function() {
                var totalMembers = $(this).val();
                $("#member_fields").html("");
                for (var i = 1; i <= totalMembers; i++) {
                    $("#member_fields").append('<input type="text" class="form-control mt-2" name="members[]" placeholder="Member ' + i + ' Name" required>');
                }
            });
        }
    </script>
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
            <li><a href="update_flat_details.php" class="active">Update Flat Details</a></li>
            <li><a href="add_notice.php">Add Notice</a></li>
            <li><a href="view_complaints.php">View Complaints</a></li>
            <li><a href="add_watchman.php">Manage Watchmen</a></li>
            <li><a href="add_penalty.php">Manage Penalty</a></li>
            <li><a href="add_maid.php">Maid Allotment</a></li>
            <li><a href="view_maintenance.php">View Maintenance Records</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="container">

            <div class="card">
                <h3 class="mb-3">Update Flat Details (Rent a Flat)</h3>
                <form method="post" action="">
                    <div class="mb-3">
                        <label>Block:</label>
                        <select name="block" id="block" required onchange="fetchFlats()" class="form-control">
                            <option value="">Select Block</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Floor:</label>
                        <input type="number" class="form-control" name="floor" id="floor" required min="1" max="10" onchange="fetchFlats()">
                    </div>

                    <div class="mb-3">
                        <label>Flat Number:</label>
                        <select name="flat_number" id="flat_number" class="form-control" required>
                            <option value="">Select Flat</option>
                            <?php foreach ($owned_flats as $flat) { ?>
                                <option value="<?= $flat ?>"><?= $flat ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Name:</label>
                        <input type="text" name="name" required class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Email:</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Contact Number:</label>
                        <input type="text" name="contact_number" class="form-control" required pattern="\d{10}" title="Enter 10-digit contact number">
                    </div>
                    <div class="mb-3">
                        <label>Total Members:</label>
                        <input type="number" name="total_members" id="total_members" required min="1" class="form-control">
                    </div>

                    <div id="member_fields"></div>

                    <button type="submit" name="rent_flat" class="btn btn-primary">Update Details</button>
                </form>
            </div>

            <div class="card">
                <h3 class="mb-3">Rented Flats</h3>
                <input type="text" id="searchInput" class="form-control mb-3" onkeyup="searchFlats()" placeholder="Search...">

                <table id="rentedFlatsTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Block</th>
                            <th>Flat Number</th>
                            <th>Renter Name</th>
                            <th>Contact Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($rented_flats_result)) { ?>
                            <tr>
                                <td><?= htmlspecialchars($row['block']) ?></td>
                                <td><?= htmlspecialchars($row['flat_number']) ?></td>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['contact_number']) ?></td>
                                <td>
                                    <form method="post" action="">
                                        <input type="hidden" name="flat_number" value="<?= htmlspecialchars($row['flat_number']) ?>">
                                        <button type="submit" class="btn btn-danger btn-sm" name="update_status">Mark as Owned</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</body>

</html>