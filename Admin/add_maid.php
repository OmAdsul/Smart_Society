<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

include_once('../config/db_connection.php');
$admin_username = $_SESSION['admin_username'];


$block_query = "SELECT DISTINCT block FROM Flat_Allotment";
$block_result = mysqli_query($conn, $block_query);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_maid'])) {
    $name = $_POST['name'];
    $contact_number = $_POST['contact_number'];
    $block = $_POST['block'];
    $flat_number = $_POST['flat_number'];
    $maid_number = $_POST['maid_number'];


    $check_query = "SELECT * FROM Maids WHERE maid_number = '$maid_number'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Error: Maid number already exists!');</script>";
    } else {
        $sql = "INSERT INTO Maids (maid_number, name, contact_number, block, flat_number) 
                VALUES ('$maid_number', '$name', '$contact_number', '$block', '$flat_number')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Maid added successfully!'); window.location.href='add_maid.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }
}


$maids_query = "SELECT * FROM Maids order by maid_number desc ";
$maids_result = mysqli_query($conn, $maids_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Maids</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#block").change(function() {
                var block = $(this).val();
                $.ajax({
                    url: "fetch_floors.php",
                    type: "POST",
                    data: {
                        block: block
                    },
                    success: function(data) {
                        $("#floor").html(data);
                        $("#flat_number").html('<option value="">Select Flat</option>');
                    }
                });
            });

            $("#floor").change(function() {
                var block = $("#block").val();
                var floor = $(this).val();
                $.ajax({
                    url: "maid_fetch_flats.php",
                    type: "POST",
                    data: {
                        block: block,
                        floor: floor
                    },
                    success: function(data) {
                        $("#flat_number").html(data);
                    }
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
            <li><a href="add_penalty.php">Manage Penalty</a></li>
            <li><a href="add_maid.php" class="active">Maid Allotment</a></li>
            <li><a href="view_maintenance.php">View Maintenance Records</a></li>
        </ul>
    </div>

    <div class="container">
        <div class="card">
            <h2 class="text-center">Add Maid</h2>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Maid Number:</label>
                    <input type="text" name="maid_number" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Name:</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contact Number:</label>
                    <input type="text" name="contact_number" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Block:</label>
                    <select name="block" class="form-control" id="block" required>
                        <option value="">Select Block</option>
                        <?php while ($row = mysqli_fetch_assoc($block_result)) { ?>
                            <option value="<?php echo $row['block']; ?>"><?php echo $row['block']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Floor:</label>
                    <select class="form-select" name="floor" id="floor" required>
                        <option value="">Select Floor</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Flat Number:</label>
                    <select class="form-select" name="flat_number" id="flat_number" required>
                        <option value="">Select Flat</option>
                    </select>
                </div>
                <button type="submit" name="add_maid" class="btn btn-primary w-100">Add Maid</button>
            </form>
        </div>

        <div class="card mt-4">
            <h2 class="text-center">Registered Maids</h2>
            <table class="table table-bordered">
                <tr>
                    <th>Maid Number</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Block</th>
                    <th>Flat No.</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($maids_result)) { ?>
                    <tr>
                        <td><?php echo $row['maid_number']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['contact_number']; ?></td>
                        <td><?php echo $row['block']; ?></td>
                        <td><?php echo $row['flat_number']; ?></td>
                        <td>
                            <a href="update_maid.php?id=<?php echo $row['maid_number']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_maid.php?id=<?php echo $row['maid_number']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this maid?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>

</body>

</html>