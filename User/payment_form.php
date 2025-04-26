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

if (!isset($_GET['type'])) {
    echo "Invalid request.";
    exit;
}

$type = $_GET['type'];

if ($type == 'penalty' && isset($_GET['penalty_id'])) {
    $payment_id = $_GET['penalty_id'];
    $query = "SELECT * FROM Penalties WHERE penalty_id='$payment_id'";
    $result = mysqli_query($conn, $query);
    $paymentData = mysqli_fetch_assoc($result);
    $payment_reason = "Penalty Payment";
} elseif ($type == 'maintenance' && isset($_GET['maintenance_id'])) {
    $payment_id = $_GET['maintenance_id'];
    $query = "SELECT * FROM Maintenance WHERE maintenance_id='$payment_id'";
    $result = mysqli_query($conn, $query);
    $paymentData = mysqli_fetch_assoc($result);
    $payment_reason = "Maintenance Payment";
} else {
    echo "Invalid request.";
    exit;
}

if (!$paymentData) {
    echo "Payment record not found.";
    exit;
}

$userQuery = "SELECT phone FROM Users WHERE user_id='$user_id'";
$userResult = mysqli_query($conn, $userQuery);
$userData = mysqli_fetch_assoc($userResult);
$registered_mobile = $userData['phone'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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

        .container {
            margin-left: 260px;
            padding: 20px;
            width: calc(100% - 300px);
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: white;
            padding: 20px;
        }

        .btn-primary {
            background-color: #ff6f61;
            border: none;
        }

        .btn-primary:hover {
            background-color: #ff6f61;
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
            <span class="navbar-text ms-auto me-3">Welcome, <?php echo htmlspecialchars($user['name']); ?></span>
            <a href="owner_dashboard.php" class="btn btn-primary btn-sm">Back to Homepage</a>
        </div>
    </nav>

    <div class="sidebar">
        <ul>
            <li><a href="user_dashboard.php">Dashboard</a></li>
            <li><a href="view_notices.php">View Notices</a></li>
            <li><a href="make_payment.php" class="active">Make Payment</a></li>
            <li><a href="view_complaints.php">View Complaints</a></li>
            <li><a href="update_profile.php">Update Profile</a></li>
            <li><a href="user_logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="container">
        <div class="card">
            <h2 class="text-center">Payment Form</h2>
            <form method="post" action="send_otp.php">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <input type="hidden" name="payment_type" value="<?php echo $type; ?>">
                <input type="hidden" name="reference_id" value="<?php echo $payment_id; ?>">
                <input type="hidden" name="amount" value="<?php echo $paymentData['amount']; ?>">

                <div class="mb-3">
                    <label class="form-label">Payment For:</label>
                    <input type="text" class="form-control" value="<?php echo $payment_reason; ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Amount:</label>
                    <input type="text" class="form-control" value="<?php echo $paymentData['amount']; ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Registered Mobile:</label>
                    <input type="text" class="form-control" value="<?php echo $registered_mobile; ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Card Type:</label>
                    <select name="card_type" class="form-control" required>
                        <option value="Credit">Credit</option>
                        <option value="Debit">Debit</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">CVV:</label>
                    <input type="password" name="cvv" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Expiry Date:</label>
                    <input type="text" name="expiry_date" class="form-control" placeholder="MM/YY" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Proceed with OTP</button>
            </form>
        </div>
    </div>

</body>

</html>