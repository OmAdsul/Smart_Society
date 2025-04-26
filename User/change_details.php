<?php
session_start();
include_once('../config/db_connection.php');


if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    header("Location: user_login.php");
    exit;
}


$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];



$sql = "SELECT * FROM Users WHERE user_id='$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $phone = $_POST['phone'];


    if ($user_type === 'Owner') {
        $name = $_POST['name'];
        $sql = "UPDATE Users SET name='$name', email='$email', phone='$phone' WHERE user_id='$user_id'";
    } else {
        $sql = "UPDATE Users SET email='$email', phone='$phone' WHERE user_id='$user_id'";
    }

    if (mysqli_query($conn, $sql)) {
        $success_message = "Details updated successfully.";
    } else {
        $error_message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Details</title>
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
            text-align: center;
        }


        .form-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }

        .form-container h4 {
            color: #ff6f61;
            font-weight: 500;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .btn-update {
            width: 100%;
            background-color: #ff6f61;
            color: #ffffff;
            font-size: 16px;
            padding: 10px;
            border-radius: 5px;
            border: none;
            transition: 0.3s ease;
        }

        .btn-update:hover {
            background-color: #e05a47;
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
            <span class="navbar-text ms-auto me-3">Welcome, <?php echo htmlspecialchars($user['name']); ?> (<?php echo $user_type; ?>)</span>
            <a href="user_logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </nav>


    <div class="d-flex">
        <div class="sidebar">
            <ul>
                <li><a href="<?php echo ($user_type === 'Owner') ? 'owner_dashboard.php' : 'renter_dashboard.php'; ?>">Dashboard</a></li>

                <li><a href="change_details.php" class="active">Update Profile</a></li>
                <?php if ($user_type === 'Owner') { ?>
                    <li><a href="make_payment.php">View Payments</a></li>
                <?php } ?>
                <li><a href="view_notices.php">View Notices</a></li>
                <li><a href="register_complaint.php">Register Complaints</a></li>
            </ul>
        </div>


        <div class="main-content">
            <h2>Change Details</h2>

            <div class="form-container">
                <h4>Update Your Profile</h4>

                <?php if (isset($success_message)) { ?>
                    <div class="alert alert-success"><?php echo $success_message; ?></div>
                <?php } ?>

                <?php if (isset($error_message)) { ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php } ?>

                <form method="post">
                    <?php if ($user_type === 'Owner') { ?>
                        <div class="form-group">
                            <label>Name:</label>
                            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" readonly>
                        </div>
                    <?php } else { ?>
                        <div class="form-group">
                            <label>Name:</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" readonly>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Phone:</label>
                        <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                    </div>

                    <button type="submit" class="btn btn-update">Update</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>