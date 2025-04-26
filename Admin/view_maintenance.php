<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

include_once('../config/db_connection.php');
$admin_username = $_SESSION['admin_username'];

$maintenance_query = "SELECT * FROM Maintenance ORDER BY status ASC, date_added DESC";
$maintenance_result = mysqli_query($conn, $maintenance_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Maintenance</title>
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

        .navbar-brand,
        .navbar-text {
            color: #ffffff !important;
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

        .search-bar {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .table {
            margin-top: 20px;
            border-radius: 10px;
            overflow: hidden;
        }

        .table th {
            background-color: #ff6f61;
            color: white;
            text-align: center;
        }

        .table td {
            color: #2c3e50;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>

    <script>
        function searchTable() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("maintenanceTable");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) {
                tr[i].style.display = "none";
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        }
                    }
                }
            }
        }
    </script>
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
            <li><a href="add_watchman.php">Manage Watchmen</a></li>
            <li><a href="add_penalty.php">Manage Penalty</a></li>
            <li><a href="add_maid.php">Maid Allotment</a></li>
            <li><a href="view_maintenance.php" class="active">View Maintenance Records</a></li>
        </ul>
    </div>

    <div class="container">
        <div class="card">
            <h2 class="text-center">Maintenance Records</h2>

            <div class="text-end mb-3">
                <a href="generate_maintenance.php" onclick="return confirm('Are you sure you want to generate maintenance for this month?');">
                    <button class="btn btn-primary">Generate Maintenance</button>
                </a>
            </div>

            <input type="text" id="searchInput" onkeyup="searchTable()" class="search-bar" placeholder="Search Maintenance...">

            <table class="table table-bordered text-center" id="maintenanceTable">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Block</th>
                        <th>Flat Number</th>
                        <th>Flat Type</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Payment Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($maintenance_result)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['month_year']); ?></td>
                            <td><?php echo htmlspecialchars($row['block']); ?></td>
                            <td><?php echo htmlspecialchars($row['flat_number']); ?></td>
                            <td><?php echo htmlspecialchars($row['flat_type']); ?></td>
                            <td><?php echo htmlspecialchars($row['amount']); ?></td>
                            <td>
                                <?php if ($row['status'] === 'Paid') { ?>
                                    <span class="badge bg-success">Paid</span>
                                <?php } else { ?>
                                    <span class="badge bg-danger">Unpaid</span>
                                <?php } ?>
                            </td>
                            <td><?php echo $row['date_paid'] ? date('Y-m-d', strtotime($row['date_paid'])) : 'Not Paid'; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>