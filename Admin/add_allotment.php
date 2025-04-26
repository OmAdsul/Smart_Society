<?php
session_start();


if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

include_once('../config/db_connection.php');

$admin_username = $_SESSION['admin_username'];


if (isset($_GET['delete'])) {
    $flat_number = $_GET['delete'];
    $deleteQuery = "DELETE FROM Flat_Allotment WHERE flat_number = ?";
    $stmt = mysqli_prepare($conn, $deleteQuery);
    mysqli_stmt_bind_param($stmt, "s", $flat_number);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Flat allotment deleted successfully!'); window.location.href='add_allotment.php';</script>";
    } else {
        echo "<script>alert('Error deleting flat allotment!');</script>";
    }
}


$allotmentsQuery = "SELECT flat_number, block, name, contact_number, ownership_status FROM Flat_Allotment";
$result = mysqli_query($conn, $allotmentsQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flat Allotment</title>


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
            width: calc(100% - 300px);
            padding: 20px;
            overflow-x: hidden;
            color: #2c3e50;
        }

        .card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
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

        #search {
            max-width: 300px;
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
        $(document).ready(function() {
            $("#block, #floor, #flat_type").change(function() {
                var block = $("#block").val();
                var floor = $("#floor").val();
                var flatType = $("#flat_type").val();

                if (block && floor && flatType) {
                    $.ajax({
                        url: "fetch_flats.php",
                        type: "POST",
                        data: {
                            block: block,
                            floor: floor,
                            flat_type: flatType
                        },
                        success: function(response) {
                            $("#flat_number").html(response);
                        }
                    });
                }
            });

            $("#flat_type").change(function() {
                var flatType = $(this).val();
                if (flatType) {
                    $.ajax({
                        url: "fetch_maintenance.php",
                        type: "POST",
                        data: {
                            flat_type: flatType
                        },
                        success: function(response) {
                            $("#maintenance_charge").val(response);
                        }
                    });
                }
            });

            $("#total_members").change(function() {
                var totalMembers = $(this).val();
                $("#member_fields").html("");
                for (var i = 1; i <= totalMembers; i++) {
                    $("#member_fields").append('<input type="text" class="form-control mt-2" name="members[]" placeholder="Member ' + i + ' Name" required>');
                }
            });

            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#allotmentTable tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
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
            <li><a href="add_allotment.php" class="active">Manage Flats</a></li>
            <li><a href="update_flat_details.php">Update Flat Details</a></li>
            <li><a href="add_notice.php">Add Notice</a></li>
            <li><a href="view_complaints.php">View Complaints</a></li>
            <li><a href="add_watchman.php">Manage Watchmen</a></li>
            <li><a href="add_penalty.php">Manage Penalty</a></li>
            <li><a href="add_maid.php">Maid Allotment</a></li>
            <li><a href="view_maintenance.php">View Maintenance Records</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h2>Flat Allotment</h2>


        <div class="card">
            <h4>Allot a New Flat</h4>
            <form method="POST" action="process_allotment.php">
                <div class="mb-3">
                    <label>Name:</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Contact Number:</label>
                    <input type="text" name="contact_number" class="form-control" required pattern="\d{10}" title="Enter 10-digit contact number">
                </div>
                <div class="mb-3">
                    <label>Block:</label>
                    <select name="block" id="block" class="form-control" required>
                        <option value="">Select Block</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Floor:</label>
                    <input type="number" name="floor" id="floor" class="form-control" required min="1" max="10">
                </div>
                <div class="mb-3">
                    <label>Flat Type:</label>
                    <select name="flat_type" id="flat_type" class="form-control" required>
                        <option value="">Select Type</option>
                        <option value="1BHK">1BHK</option>
                        <option value="2BHK">2BHK</option>
                        <option value="3BHK">3BHK</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Flat Number:</label>
                    <select name="flat_number" id="flat_number" class="form-control" required></select>
                </div>
                <div class="mb-3">
                    <label>Maintenance Charge:</label>
                    <input type="text" name="maintenance_charge" id="maintenance_charge" class="form-control" readonly required>
                </div>
                <div class="mb-3">
                    <label>Total Members:</label>
                    <input type="number" name="total_members" id="total_members" class="form-control" required min="1">
                </div>
                <div id="member_fields"></div>

                <button type="submit" class="btn btn-primary mt-3">Allot Flat</button>
            </form>
        </div>

        <h4>Existing Flat Allotments</h4>
        <input type="text" id="search" class="form-control mb-3" placeholder="Search allotments...">

        <table class="table table-bordered" id="allotmentTable">
            <thead>
                <tr>
                    <th>Block</th>
                    <th>Flat Number</th>
                    <th>Owner Name</th>
                    <th>Contact</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= $row['block'] ?></td>
                        <td><?= $row['flat_number'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['contact_number'] ?></td>
                        <td><?= ucfirst(htmlspecialchars($row['ownership_status'])) ?></td>
                        <td>
                            <a href="add_allotment.php?delete=<?= urlencode($row['flat_number']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this allotment?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>

</html>