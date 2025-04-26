<?php
session_start();
include_once('../config/db_connection.php');
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    header("Location: user_login.php");
    exit;
}


$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];


$user_id = $_SESSION['user_id'];
$user_flat_number = $_SESSION['flat_number'];
$user_block = $_SESSION['block'];

$sql = "SELECT * FROM Users WHERE user_id='$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

$sql = "SELECT * FROM Notices ORDER BY date_created DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Notices</title>
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

        .notice-card {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .notice-card h3 {
            color: #ff6f61;
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .notice-card p {
            font-size: 16px;
            color: #2c3e50;
        }

        .notice-date {
            font-size: 14px;
            color: #6c757d;
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
            <span class="navbar-text ms-auto me-3">Welcome, <?php echo htmlspecialchars($user['name']); ?></span>
            <a href="user_logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </nav>

    <div class="d-flex">
        <div class="sidebar">
            <ul>
                <li><a href="<?php echo ($user_type === 'Owner') ? 'owner_dashboard.php' : 'renter_dashboard.php'; ?>">Dashboard</a></li>
                <li><a href="change_details.php">Update Profile</a></li>
                <?php if ($user_type === 'Owner') { ?>
                    <li><a href="make_payment.php">View Payments</a></li>
                <?php } ?>
                <li><a href="view_notices.php" class="active">View Notices</a></li>
                <li><a href="register_complaint.php">Register Complaints</a></li>
            </ul>
        </div>

        <div class="main-content">
            <h2>Notices</h2>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="notice-card">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                    <p class="notice-date">Posted on: <?php echo htmlspecialchars($row['date_created']); ?></p>
                </div>
            <?php } ?>

        </div>
    </div>

</body>

</html>