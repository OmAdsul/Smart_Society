<?php
include_once('../config/db_connection.php');

$message = "";
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $query = "SELECT * FROM users WHERE reset_token='$token' AND token_expiry > NOW()";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            if ($new_password !== $confirm_password) {
                echo "Passwords do not match.";
            } else {
                $hashed = password_hash($new_password, PASSWORD_BCRYPT);
                $update = "UPDATE users SET password='$hashed', reset_token=NULL, token_expiry=NULL WHERE reset_token='$token'";
                mysqli_query($conn, $update);
                $message = "<div class='alert alert-success'>Password reset successful. <a href='user_login.php'>Login here</a>.</div>";
            }
        }
    } else {
        $message = "<div class='alert alert-danger'>Invalid or expired token.</div>";
    }
} else {
    $message = "<div class='alert alert-danger'>Invalid access.</div>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('../Images/sample.jpg') no-repeat center center/cover;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            height: 100vh;
        }

        .navbar {
            background-color: #2c3e50;
            padding: 15px;
        }

        .navbar-brand {
            color: #ffffff !important;
            font-weight: 500;
            font-size: 22px;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }

        .card {
            border-radius: 10px;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
        }

        .form-label {
            font-weight: 500;
        }

        .btn-primary {
            background-color: #ff6f61;
            border: none;
        }

        .btn-primary:hover {
            background-color: #e05a47;
        }

        h2 {
            margin-bottom: 20px;
            font-weight: 500;
            text-align: center;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Smart Society</a>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h2>Reset Your Password</h2>
            <?php echo $message; ?>
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Reset Password</button>
            </form>
        </div>
    </div>
</body>

</html>