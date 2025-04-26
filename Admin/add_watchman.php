<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

include_once('../config/db_connection.php');
$admin_username = $_SESSION['admin_username'];


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_watchman'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $joining_date = $_POST['joining_date'];
    $salary = $_POST['salary'];
    $working_shift = $_POST['working_shift'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO Watchmen (name, phone, joining_date, salary, working_shift, password) 
            VALUES ('$name', '$phone', '$joining_date', '$salary', '$working_shift', '$hashed_password')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Watchman added successfully!'); window.location.href='add_watchman.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}


$watchmen_query = "SELECT * FROM Watchmen";
$watchmen_result = mysqli_query($conn, $watchmen_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Watchmen</title>
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
            color: #2c3e50;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: white;
            color: #2c3e50;
            padding: 20px;
        }

        .btn-primary {
            background-color: #ff6f61;
            border: none;
        }

        .btn-primary:hover {
            background-color: #e05a47;
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

        th,
        td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            color: #2c3e50;
        }

        th {
            background-color: #ff6f61;
            /* color: white; */
            color: #2c3e50;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Smart Society</a>
            <span class="navbar-text ms-auto me-3">Welcome, <?php echo htmlspecialchars($admin_username); ?></span>
            <a href="admin_logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </nav>

    <div class="sidebar">
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="add_allotment.php">Manage Flats</a></li>
            <li><a href="update_flat_details.php">Update Flat Details</a></li>
            <li><a href="add_notice.php">Add Notice</a></li>
            <li><a href="view_complaints.php">View Complaints</a></li>
            <li><a href="add_watchman.php" class="active">Manage Watchmen</a></li>
            <li><a href="add_penalty.php">Manage Penalty</a></li>
            <li><a href="add_maid.php">Maid Allotment</a></li>
            <li><a href="view_maintenance.php">View Maintenance Records</a></li>
        </ul>
    </div>

    <div class="container">
        <div class="card">
            <h2 class="text-center">Add Watchman</h2>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Name:</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone:</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Joining Date:</label>
                    <input type="date" name="joining_date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Salary:</label>
                    <input type="number" name="salary" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Working Shift:</label>
                    <select name="working_shift" class="form-control" required>
                        <option value="morning">Morning</option>
                        <option value="evening">Evening</option>
                        <option value="night">Night</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" name="add_watchman" class="btn btn-primary w-100">Add Watchman</button>
            </form>
        </div>

        <div class="card mt-4">
            <h2 class="text-center">Registered Watchmen</h2>
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Salary</th>
                    <th>Joining Date</th>
                    <th>Working Shift</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($watchmen_result)) { ?>
                    <tr>
                        <td><?php echo $row['watchman_id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['salary']; ?></td>
                        <td><?php echo date('Y-m-d', strtotime($row['joining_date'])); ?></td>
                        <td><?php echo ucfirst($row['working_shift']); ?></td>
                        <td>
                            <a href="update_watchman.php?id=<?php echo $row['watchman_id']; ?>" class="btn btn-warning btn-sm">Update</a>
                            <a href="delete_watchman.php?id=<?php echo $row['watchman_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this watchman?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>

</body>

</html>