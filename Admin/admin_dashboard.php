<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

include_once('../config/db_connection.php');


$admin_username = $_SESSION['admin_username'];


$totalFlats = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM Flat_Allotment"))['count'];
$totalVisitors = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM Visitors"))['count'];
$totalWatchmen = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM Watchmen"))['count'];
$totalComplaints = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM Complaints"))['count'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
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

        .btn-danger {
            font-size: 14px;
            padding: 5px 10px;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #2c3e50;
            position: sticky;
            top: 0;
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
            padding: 30px;
            width: 100%;
            overflow-x: hidden;
        }

        h2 {
            color: #2c3e50;
            font-weight: 500;
            margin-bottom: 20px;
        }


        .info-card {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .info-card h4 {
            font-weight: 500;
            color: #ff6f61;

            margin-bottom: 10px;
        }

        .info-card p {
            font-size: 20px;
            font-weight: 600;
            color: #e05a47;
        }


        .d-flex {
            display: flex;
            flex-wrap: nowrap;
        }


        @media (max-width: 992px) {
            .sidebar {
                width: 200px;
            }

            .sidebar ul li a {
                font-size: 14px;
            }

            .main-content {
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            .d-flex {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .sidebar ul {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-around;
            }

            .sidebar ul li {
                flex: 1;
                text-align: center;
            }

            .sidebar ul li a {
                padding: 10px;
            }
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


    <div class="d-flex">

        <div class="sidebar">
            <ul>
                <li><a href="admin_dashboard.php" class="active">Dashboard</a></li>
                <li><a href="add_allotment.php">Manage Flats</a></li>
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
            <h2>Dashboard Overview</h2>

            <div class="row">
                <div class="col-md-3">
                    <div class="info-card">
                        <h4>Total Flats</h4>
                        <p><?php echo $totalFlats; ?></p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-card">
                        <h4>Total Visitors</h4>
                        <p><?php echo $totalVisitors; ?></p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-card">
                        <h4>Total Watchmen</h4>
                        <p><?php echo $totalWatchmen; ?></p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-card">
                        <h4>Total Complaints</h4>
                        <p><?php echo $totalComplaints; ?></p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>

</html>