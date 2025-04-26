<?php
session_start();
include_once('../config/db_connection.php');

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    header("Location: user_login.php");
    exit;
}


$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];

$user_flat_number = $_SESSION['flat_number'];
$user_block = $_SESSION['block'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['complaint_type'];
    $description = $_POST['description'];

    $sql = "INSERT INTO Complaints (user_id, complaint_type, description) 
            VALUES ('$user_id', '$type', '$description')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Complaint registered successfully.');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

$sql = "SELECT * FROM Users WHERE user_id='$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);


$complaint_query = "SELECT * FROM complaints WHERE user_id='$user_id'";
$complaint_result = mysqli_query($conn, $complaint_query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Complaint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        /* Navbar */
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

        /* Sidebar */
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

        /* Main Content */
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


        h3 {
            text-align: center;
        }

        /* Complaint Form */
        .complaint-form {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            margin: 45px auto;
        }

        .complaint-form label {
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 5px;
        }


        .table {
            background: #ffffff;
            margin: 20px 0px;
            padding: 20px;

        }

        .table th {
            background: #ff6f61;
            color: #ffffff;
        }

        .complaint-form select,
        .complaint-form textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .complaint-form button {
            background-color: #ff6f61;
            color: #ffffff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }

        .complaint-form button:hover {
            background-color: #e05a47;
        }

        /* Responsive Design */
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
                <li><a href="view_notices.php">View Notices</a></li>
                <li><a href="register_complaint.php" class="active">Register Complaints</a></li>
            </ul>
        </div>

        <div class="main-content">
            <h2>Register Complaint</h2>

            <div class="complaint-form">
                <form method="post" action="">
                    <label>Complaint Type:</label>
                    <select name="complaint_type" required>
                        <option value="plumbing">Plumbing</option>
                        <option value="electrical">Electrical</option>
                        <option value="security">Security</option>
                        <option value="other">other</option>
                    </select>

                    <label>Description:</label>
                    <textarea name="description" rows="4" required></textarea>

                    <button type="submit">Submit Complaint</button>
                </form>
            </div>


            <h3>Complaints Registered</h3>
            <table class="table table-bordered table-striped">
                <tr>
                    <th>Description</th>
                    <th>Date Registered</th>
                    <th>Date Completed</th>
                    <th>Status</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($complaint_result)) { ?>
                    <tr>
                        <td><?php echo ucfirst($row['description']); ?></td>
                        <td><?php echo $row['date_raised']; ?></td>
                        <td><?php echo $row['date_completed']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                <?php } ?>
            </table>

        </div>
    </div>

</body>

</html>