<?php
include_once('../config/db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

        $updateQuery = "UPDATE users SET reset_token='$token', token_expiry='$expiry' WHERE email='$email'";
        mysqli_query($conn, $updateQuery);

        $resetLink = "http://localhost/society1/reset_password.php?token=$token";


        $subject = "Reset Your Password - Smart Society";
        $message = "Click the link below to reset your password:\n$resetLink\n\nThis link will expire in 1 hour.";
        $headers = "From: 21omadsul@gmail.com";

        mail($email, $subject, $message, $headers);

        echo "<script>alert('A password reset link has been sent to your email');</script>";
    } else {
        echo "<script>alert('No user found with this email');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            background: url('../Images/sample.jpg') no-repeat center center/cover;
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
            background-color: #e05a47;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Smart Society</a>
            <a class="navbar-brand" href="user_login.php">Back to page</a>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h2 class="text-center">Forget password ?</h2>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Enter your registered email:</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
            </form>
        </div>
    </div>
</body>

</html>