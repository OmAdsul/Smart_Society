<?php
session_start();
if (!isset($_SESSION['watchman_id'])) {
    header("Location: watchman_login.php");
    exit();
}

include_once('../config/db_connection.php');


$watchman_name = $_SESSION['watchman_name'];
$watchman_id = $_SESSION['watchman_id'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $query = "UPDATE Watchmen SET password='$hashed_password' WHERE watchman_id='$watchman_id'";

        if (mysqli_query($conn, $query)) {
            $message = "Password updated successfully!";
        } else {
            $message = "Error updating password: " . mysqli_error($conn);
        }
    } else {
        $message = "Passwords do not match!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #2c3e50;
            padding: 10px 20px;
        }

        .navbar-brand,
        .navbar-text {
            color: #ffffff !important;
        }

        .btn-danger {
            font-size: 14px;
            padding: 5px 12px;
        }

        .container-fluid {
            display: flex;
            padding: 0;
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            padding-top: 20px;
            min-height: 100vh;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
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
            transition: 0.3s;
        }

        .sidebar ul li a:hover,
        .sidebar ul li a.active {
            background-color: #ff6f61;
        }

        .main-content {
            flex-grow: 1;
            padding: 40px;
        }

        h2 {
            color: #2c3e50;
            font-weight: 500;
            text-align: center;
        }

        .form-container {
            background: #ffffff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 550px;
            margin: auto;
        }

        .form-container label {
            font-weight: 500;
        }

        .form-container input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .form-container input[type="submit"] {
            background-color: #ff6f61;
            color: white;
            font-weight: 500;
            border: none;
            cursor: pointer;
            padding: 10px;
            width: 100%;
        }

        .form-container input[type="submit"]:hover {
            background-color: #e05a47;
        }

        .alert {
            max-width: 550px;
            margin: 20px auto;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Smart Society</a>
            <span class="navbar-text ms-auto me-3">Welcome, Watchman</span>
            <a href="watchman_logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="sidebar">
            <ul>
                <li><a href="watchman_dashboard.php">Dashboard</a></li>
                <li><a href="update_visitor_remark.php">Update Visitor Remark</a></li>
                <li><a href="update_maid_remark.php">Update Maid Remark</a></li>
                <li><a href="change_watchman_password.php" class="active">Change Password</a></li>
            </ul>
        </div>

        <div class="main-content">
            <h2>Change Password</h2>

            <?php if (!empty($message)) : ?>
                <div class="alert alert-info text-center"><?php echo $message; ?></div>
            <?php endif; ?>

            <div class="form-container">
                <form method="POST" action="">
                    <label for="new_password">New Password:</label>
                    <input type="password" name="new_password" id="new_password" required>

                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" name="confirm_password" id="confirm_password" required>

                    <input type="submit" value="Change Password">
                </form>
            </div>
        </div>
    </div>

</body>

</html>