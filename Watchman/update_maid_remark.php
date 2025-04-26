<?php
session_start();
if (!isset($_SESSION['watchman_id'])) {
    header("Location: watchman_login.php");
    exit();
}

include_once('../config/db_connection.php');

$recent_visits = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_remark'])) {
    $maid_number = $_POST['maid_number'];
    $maid_name = $_POST['maid_name'];
    $block = $_POST['block'];
    $flat_number = $_POST['flat_number'];
    $remark_type = $_POST['remark_type'];
    $remark_time = date('Y-m-d H:i:s');


    $maid_query = "SELECT maid_id FROM Maids WHERE maid_number = ?";
    $stmt = mysqli_prepare($conn, $maid_query);
    mysqli_stmt_bind_param($stmt, "s", $maid_number);
    mysqli_stmt_execute($stmt);
    $maid_result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($maid_result) > 0) {
        $maid_data = mysqli_fetch_assoc($maid_result);
        $maid_id = $maid_data['maid_id'];

        $insert_query = "INSERT INTO maid_visits (maid_id, maid_number, maid_name, flat_number, remark_type, remark_time)
                         VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insert_query);
        mysqli_stmt_bind_param($stmt, "isssss", $maid_id, $maid_number, $maid_name, $flat_number, $remark_type, $remark_time);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: update_maid_remark.php?success=1");
            exit();
        } else {
            echo "<script>alert('Failed to insert remark.');</script>";
        }
    } else {
        echo "<script>alert('Maid not found in the database.');</script>";
    }
}


$block_query = "SELECT DISTINCT block FROM Flat_Allotment ORDER BY block";
$block_result = mysqli_query($conn, $block_query);

$recent_query = "SELECT * FROM Maid_Visits ORDER BY remark_time DESC LIMIT 10";
$recent_result = mysqli_query($conn, $recent_query);
$recent_visits = mysqli_fetch_all($recent_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Maid Remark</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <script>
        $(document).ready(function() {
            $("#maid_number").on("input", function() {
                var maid_number = $(this).val();
                if (maid_number.length > 5) {
                    $.ajax({
                        url: "fetch_maid.php",
                        method: "POST",
                        data: {
                            maid_number: maid_number
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.success) {
                                $("#maid_name").val(response.maid_name);
                            } else {
                                $("#maid_name").val("");
                                alert(response.message);
                            }
                        }
                    });
                } else {
                    $("#maid_name").val("");
                }
            });

            $("#maid_number, #block").on("change", function() {
                var block = $('#block').val();
                var maid_number = $('#maid_number').val();

                if (block !== "" && maid_number !== "") {
                    $.ajax({
                        url: "mfetch_flats.php",
                        method: "POST",
                        data: {
                            block: block,
                            maid_number: maid_number
                        },
                        success: function(response) {
                            $("#flat_number").html(response);
                        }
                    });
                } else {
                    $("#flat_number").html('<option value="">Select Flat</option>');
                }
            });

            $("#search_maid").on("keyup", function() {
                var searchValue = $(this).val().toLowerCase();
                $("#maidTable tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
                });
            });
        });
    </script>

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
            width: 100%;
        }

        .form-container input[type="submit"]:hover {
            background-color: #e05a47;
        }

        .table-container {
            margin-top: 20px;
        }

        .table {
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table th {
            background-color: #2c3e50;
            color: white;
            padding: 12px;
        }

        .table td {
            padding: 12px;
            text-align: center;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f8f9fa;
        }

        .search-box {
            margin-bottom: 15px;
            text-align: right;
        }

        .search-box input {
            width: 250px;
            padding: 8px;
            border: 1px solid #ced4da;
            border-radius: 4px;
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
                <li><a href="update_maid_remark.php" class="active">Update Maid Remark</a></li>
                <li><a href="change_watchman_password.php">Change Password</a></li>
            </ul>
        </div>

        <div class="main-content">
            <h2>Update Maid Remark</h2>
            <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                <div class="alert alert-success">Maid remark successfully updated!</div>
            <?php endif; ?>

            <div class="form-container">
                <form method="post" action="">
                    <label>Maid Number:</label>
                    <input type="text" id="maid_number" name="maid_number" required>

                    <label>Maid Name:</label>
                    <input type="text" id="maid_name" name="maid_name" readonly>

                    <label>Block:</label>
                    <select id="block" name="block" required>
                        <option value="">Select Block</option>
                        <?php while ($row = mysqli_fetch_assoc($block_result)) { ?>
                            <option value="<?php echo $row['block']; ?>"><?php echo $row['block']; ?></option>
                        <?php } ?>
                    </select>

                    <label>Flat Number:</label>
                    <select id="flat_number" name="flat_number" required>
                        <option value="">Select Flat</option>
                    </select>

                    <label>Remark Type:</label>
                    <select name="remark_type" required>
                        <option value="in">Remark In</option>
                        <option value="out">Remark Out</option>
                    </select>

                    <input type="submit" name="update_remark" value="Update Remark">
                </form>
            </div>

            <div class="table-container">
                <div class="search-box">
                    <input type="text" id="search_maid" placeholder="Search maid entries...">
                </div>
                <table class="table table-striped" id="maidTable">
                    <thead>
                        <tr>
                            <th>Maid Number</th>
                            <th>Maid Name</th>
                            <th>Flat Number</th>
                            <th>Remark Type</th>
                            <th>Remark Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_visits as $visit) { ?>
                            <tr>
                                <td><?= $visit['maid_number'] ?></td>
                                <td><?= $visit['maid_name'] ?></td>
                                <td><?= $visit['flat_number'] ?></td>
                                <td><?= ucfirst($visit['remark_type']) ?></td>
                                <td><?= $visit['remark_time'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</body>

</html>