<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

include_once('../config/db_connection.php');
$admin_username = $_SESSION['admin_username'];

$query = "SELECT c.complaint_id, c.complaint_type, c.description, u.flat_number, 
                 c.status, c.date_raised, c.date_completed 
          FROM Complaints c 
          JOIN Users u ON c.user_id = u.user_id";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Complaints</title>
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
            padding: 20px;
            color: #2c3e50;
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

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            color: #2c3e50;
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

        .table tr {
            color: #2c3e50;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .disabled {
            background-color: #ccc;
            pointer-events: none;
            opacity: 0.6;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
        }

        .status-select {
            padding: 5px;
            border-radius: 5px;
        }

        .btn-update {
            padding: 5px 10px;
            border: none;
            background-color: #ff6f61;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-update:hover {
            background-color: #e05a47;
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
            <li><a href="view_complaints.php" class="active">View Complaints</a></li>
            <li><a href="add_watchman.php">Manage Watchmen</a></li>
            <li><a href="add_penalty.php">Manage Penalty</a></li>
            <li><a href="add_maid.php">Maid Allotment</a></li>
            <li><a href="view_maintenance.php">View Maintenance Records</a></li>
        </ul>
    </div>

    <div class="container">
        <div class="card">
            <h2 class="text-center">View & Update Complaints</h2>
            <table class="table">
                <tr>
                    <th>Complaint ID</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Complaint By (Flat No)</th>
                    <th>Status</th>
                    <th>Date Registered</th>
                    <th>Date Completed</th>
                    <th>Action</th>
                </tr>

                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['complaint_id']; ?></td>
                        <td><?php echo ucfirst($row['complaint_type']); ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo "Flat " . $row['flat_number']; ?></td>
                        <td><?php echo ucfirst($row['status']); ?></td>
                        <td><?php echo date('Y-m-d', strtotime($row['date_raised'])); ?></td>
                        <td>
                            <?php echo ($row['status'] == 'resolved' && $row['date_completed'])
                                ? date('Y-m-d', strtotime($row['date_completed']))
                                : 'Pending'; ?>
                        </td>
                        <td>
                            <?php if ($row['status'] == 'resolved') { ?>
                                <button class="disabled">Resolved</button>
                            <?php } else { ?>
                                <form method="post">
                                    <input type="hidden" name="complaint_id" value="<?php echo $row['complaint_id']; ?>">
                                    <select name="status" class="status-select">
                                        <option value="open" <?php echo ($row['status'] == 'open') ? 'selected' : ''; ?>>Open</option>
                                        <option value="resolved">Resolved</option>
                                    </select>
                                    <button type="submit" name="update" class="btn-update">Update</button>
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>

</body>

</html>

<?php
if (isset($_POST['update'])) {
    $complaint_id = $_POST['complaint_id'];
    $status = $_POST['status'];
    $date_completed = ($status == 'resolved') ? date('Y-m-d') : NULL;

    $sql = "UPDATE Complaints SET status='$status', date_completed=" . ($date_completed ? "'$date_completed'" : "NULL") . " WHERE complaint_id='$complaint_id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Complaint updated successfully.'); window.location.href='view_complaints.php';</script>";
    } else {
        echo "<script>alert('Error updating complaint: " . mysqli_error($conn) . "');</script>";
    }
}
?>