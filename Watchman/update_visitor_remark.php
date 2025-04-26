<?php
session_start();
if (!isset($_SESSION['watchman_id'])) {
    header("Location: watchman_login.php");
    exit();
}

include_once('../config/db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_remark'])) {
    $visitor_id = $_POST['visitor_id'];
    $remark_out = date('Y-m-d H:i:s');

    $query = "UPDATE Visitors SET remark_out='$remark_out' WHERE visitor_id='$visitor_id'";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Visitor remark updated successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}


$visitor_result = mysqli_query($conn, "SELECT visitor_id, name FROM Visitors WHERE remark_out IS NULL");


$all_visitors = "SELECT name, phone, visitor_type, flat_number, block, remark_in, remark_out FROM visitors";
$result = mysqli_query($conn, $all_visitors);


$watchman_name = $_SESSION['watchman_name'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Visitor Remark</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #2c3e50;
        }

        .navbar-brand,
        .navbar-text {
            color: #ffffff !important;
        }

        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.1);
        }

        .btn-danger {
            font-size: 14px;
            padding: 5px 12px;
        }

        .wrapper {
            display: flex;
            flex-direction: row;
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            padding-top: 20px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li a {
            display: block;
            padding: 12px 20px;
            color: #ffffff;
            text-decoration: none;
            transition: 0.3s;
        }

        .sidebar ul li a:hover,
        .sidebar ul li a.active {
            background-color: #ff6f61;
        }

        .sidebar-collapsed {
            display: none;
        }

        .main-content {
            flex-grow: 1;
            padding: 40px;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
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

        .form-container input,
        .form-container select {
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
        }

        .form-container input[type="submit"]:hover {
            background-color: #e05a47;
        }

        .table-container {
            margin-top: 30px;
        }

        .table {
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table th {
            background-color: #2c3e50;
            color: white;
        }

        .table td,
        .table th {
            padding: 12px;
            text-align: center;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f8f9fa;
        }

        .search-container {
            text-align: center;
            margin-top: 30px;
        }

        .search-container input {
            padding: 8px;
            width: 300px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        @media (max-width: 768px) {
            .wrapper {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                min-height: auto;
            }

            .main-content {
                padding: 20px;
            }

            .navbar {
                width: 100%;
            }
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#search').on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#visitortable tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            // Sidebar toggle for small screens
            $("#sidebarToggle").click(function() {
                $(".sidebar").toggleClass("sidebar-collapsed");
            });
        });
    </script>

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Smart Society</a>
            <button class="navbar-toggler" type="button" id="sidebarToggle">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="ms-auto d-flex align-items-center">
                <span class="navbar-text me-3">Welcome, <?php echo htmlspecialchars($watchman_name); ?></span>
                <a href="watchman_logout.php" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="wrapper">
        <div class="sidebar">
            <ul>
                <li><a href="watchman_dashboard.php">Dashboard</a></li>
                <li><a href="update_visitor_remark.php" class="active">Update Visitor Remark</a></li>
                <li><a href="update_maid_remark.php">Update Maid Remark</a></li>
                <li><a href="change_watchman_password.php">Change Password</a></li>
            </ul>
        </div>

        <div class="main-content">
            <h2>Update Visitor Remark</h2>

            <div class="form-container">
                <form method="post">
                    <label>Select Visitor:</label>
                    <select name="visitor_id" required>
                        <?php while ($row = mysqli_fetch_assoc($visitor_result)) { ?>
                            <option value="<?php echo $row['visitor_id']; ?>"><?php echo $row['name']; ?></option>
                        <?php } ?>
                    </select>
                    <input type="submit" name="update_remark" value="Update Remark Out">
                </form>
            </div>

            <div class="search-container">
                <input type="text" id="search" class="form-control" placeholder="Search visitors...">
            </div>

            <div class="table-container">
                <table class="table table-striped" id="visitortable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Visitor Type</th>
                            <th>Flat Number</th>
                            <th>Block</th>
                            <th>In Time</th>
                            <th>Out Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                <td><?php echo htmlspecialchars($row['visitor_type']); ?></td>
                                <td><?php echo htmlspecialchars($row['flat_number']); ?></td>
                                <td><?php echo htmlspecialchars($row['block']); ?></td>
                                <td><?php echo htmlspecialchars($row['remark_in']); ?></td>
                                <td><?php echo htmlspecialchars($row['remark_out']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>