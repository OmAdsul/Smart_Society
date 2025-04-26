<?php
session_start();
include_once('../config/db_connection.php');

if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized access. <a href='user_login.php'>Login</a>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_otp = $_POST['otp'];

    if (isset($_SESSION['otp']) && isset($_SESSION['otp_expiry']) && time() <= $_SESSION['otp_expiry']) {
        if ($entered_otp == $_SESSION['otp']) {

            if (!isset($_SESSION['payment_data']) || empty($_SESSION['payment_data']['payment_type']) || empty($_SESSION['payment_data']['reference_id']) || empty($_SESSION['payment_data']['amount'])) {
                echo "<script>alert('Payment details missing. Please try again.'); window.location.href='payment_form.php';</script>";
                exit;
            }

            $payment_data = $_SESSION['payment_data'];
            $user_id = $_SESSION['user_id'];
            $flat_number = $payment_data['flat_number'];
            $block = $payment_data['block'];
            $type = $payment_data['payment_type'];
            $payment_id = $payment_data['reference_id'];
            $amount = $payment_data['amount'];

            $sql = "INSERT INTO payment_new (user_id, flat_number, block, amount, payment_status, payment_type, reference_id)
                    VALUES ('$user_id', '$flat_number', '$block', '$amount', 'Completed', '$type', '$payment_id')";

            if (mysqli_query($conn, $sql)) {
                if ($type == 'penalty') {
                    mysqli_query($conn, "UPDATE penalties SET status='Paid', date_solved=CURDATE() WHERE penalty_id='$payment_id'");
                } elseif ($type == 'maintenance') {
                    mysqli_query($conn, "UPDATE maintenance SET status='Paid' WHERE maintenance_id='$payment_id'");
                }


                $user_query = mysqli_query($conn, "SELECT email FROM users WHERE user_id = '$user_id'");
                $user_row = mysqli_fetch_assoc($user_query);
                $email = $user_row['email'];

                $subject = "Payment Successful - Smart Society";
                $message = "Dear User,\n\nYour payment has been successfully completed.\n\nDetails:\nPayment Type: $type\nAmount: ₹$amount\nReference ID: $payment_id\nFlat: $flat_number, Block: $block\n\nThank you for your payment.\n\nSmart Society Team";
                $headers = "From: no-reply@smartsociety.com";

                mail($email, $subject, $message, $headers);
                unset($_SESSION['otp']);
                unset($_SESSION['otp_expiry']);
                unset($_SESSION['payment_data']);



                echo "<script>alert('Payment Successful!'); window.location.href='make_payment.php';</script>";
            } else {
                echo "<script>alert('Payment Failed: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('Invalid OTP. Please try again.'); window.location.href='verify_otp.php';</script>";
        }
    } else {
        echo "<script>alert('OTP expired. Please try again.'); window.location.href='payment_form.php';</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            background: url('../Images/sample.jpg')no-repeat center center/cover;
            height: 100vh;

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
            padding: 20px;
            justify-content: center;
            align-items: center;
            display: flex;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: white;
            padding: 20px;
            height: 30vh;
            width: 50vh;
        }

        .btn-primary {
            background-color: #ff6f61;
            border: none;
        }

        .btn-primary:hover {
            background-color: #006666;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Smart Society</a>
            <span class="navbar-text ms-auto me-3">Verify OTP</span>
            <a href="owner_dashboard.php" class="btn btn-primary btn-sm">Back to Homepage</a>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h2 class="text-center">Verify OTP</h2>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Enter OTP:</label>
                    <input type="text" name="otp" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Verify OTP</button>
            </form>
        </div>
    </div>

</body>

</html>