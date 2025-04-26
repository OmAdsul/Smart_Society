<?php
session_start();
include_once('../config/db_connection.php');

if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized access. <a href='user_login.php'>Login</a>";
    exit;
}

$user_id = $_SESSION['user_id'];
$user_flat_number = $_SESSION['flat_number'];
$user_block = $_SESSION['block'];

$sql = "SELECT * FROM Users WHERE user_id='$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);


$penalty_query = "SELECT * FROM Penalties WHERE flat_number='$user_flat_number' AND block='$user_block' AND status='Unpaid'";
$penalty_result = mysqli_query($conn, $penalty_query);


$maintenance_query = "SELECT * FROM Maintenance WHERE flat_number='$user_flat_number' AND block='$user_block' AND status='Unpaid'";
$maintenance_result = mysqli_query($conn, $maintenance_query);


$payment_query = "SELECT * FROM Payment_new WHERE user_id='$user_id' AND flat_number='$user_flat_number' AND block='$user_block' ORDER BY payment_date DESC";
$payment_result = mysqli_query($conn, $payment_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Payment</title>
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
        }

        h2 {
            color: #2c3e50;
            font-weight: 500;
            text-align: center;
        }

        .table {
            background: #ffffff;
            margin: 50px 0px;
            padding: 20px;
            align-items: center;
            text-align: center;

        }

        .table th {
            background: #ff6f61;
            color: #ffffff;
        }

        .btn-success {
            border: none;
        }

        @media (max-width: 992px) {
            .sidebar {
                width: 200px;
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
                justify-content: space-around;
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
                <li><a href="owner_dashboard.php">Dashboard</a></li>
                <li><a href="change_details.php">Update Profile</a></li>
                <li><a href="make_payment.php" class="active">View Payments</a></li>
                <li><a href="view_notices.php">View Notices</a></li>
                <li><a href="register_complaint.php">Register Complaints</a></li>
            </ul>
        </div>

        <div class="main-content">
            <h2>Make Payment</h2>

            <h3>Pending Penalties</h3>
            <table class="table table-bordered">
                <tr>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($penalty_result)) { ?>
                    <tr>
                        <td><?php echo $row['reason']; ?></td>
                        <td><?php echo $row['amount']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <?php if ($row['status'] == 'Unpaid') { ?>
                                <a href="payment_form.php?type=penalty&penalty_id=<?php echo $row['penalty_id']; ?>" class="btn btn-success">Make Payment</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>

            <h3>Pending Maintenance</h3>
            <table class="table table-bordered">
                <tr>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($maintenance_result)) { ?>
                    <tr>
                        <td><?php echo $row['amount']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <?php if ($row['status'] == 'Unpaid') { ?>
                                <a href="payment_form.php?type=maintenance&maintenance_id=<?php echo $row['maintenance_id']; ?>" class="btn btn-success">Make Payment</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>

            <h3>Recent Past Payments</h3>
            <table class="table table-bordered">
                <tr>
                    <th>Payment Type</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                    <th>Status</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($payment_result)) { ?>
                    <tr>
                        <td><?php echo ucfirst($row['payment_type']); ?></td>
                        <td><?php echo $row['amount']; ?></td>
                        <td><?php echo $row['payment_date']; ?></td>
                        <td><?php echo $row['payment_status']; ?></td>
                    </tr>
                <?php } ?>
            </table>

        </div>
    </div>

</body>

</html>