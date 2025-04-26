<?php
session_start();
include_once('../config/db_connection.php');

if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized access. <a href='user_login.php'>Login</a>";
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "SELECT email FROM Users WHERE user_id='$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (!$user || empty($user['email'])) {
    echo "Error: Email not found for the user.";
    exit;
}

$user_email = $user['email'];

$otp = rand(100000, 999999);
$_SESSION['otp'] = $otp;
$_SESSION['otp_expiry'] = time() + 300; // OTP valid for 5 minutes

$_SESSION['payment_data'] = [
    'payment_type' => $_POST['payment_type'] ?? null,
    'reference_id' => $_POST['reference_id'] ?? null,
    'amount' => $_POST['amount'] ?? null,
    'flat_number' => $_SESSION['flat_number'] ?? null,
    'block' => $_SESSION['block'] ?? null
];

$subject = "Your OTP for Payment Verification";
$message = "Dear user,\n\nYour OTP for payment verification is: $otp\n\nThis OTP is valid for 5 minutes.";
$headers = "From: admin@smartsociety.com";

if (mail($user_email, $subject, $message, $headers)) {
    header("Location: verify_otp.php");
    exit;
} else {
    echo "<script>alert('Error sending OTP. Please try again.'); window.location.href='payment_form.php';</script>";
}
