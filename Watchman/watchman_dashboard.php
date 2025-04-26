<?php
session_start();

if (!isset($_SESSION['watchman_id'])) {
    header("Location: watchman_login.php");
    exit;
}

include_once('../config/db_connection.php');

$watchman_name = $_SESSION['watchman_name'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $visitor_type = $_POST['visitor_type'];
    $flat_number = $_POST['flat_number'];
    $block = $_POST['block'];
    $remark_in = date('Y-m-d H:i:s');

    $query = "INSERT INTO Visitors (name, phone, visitor_type, flat_number, block, remark_in) 
              VALUES ('$name', '$phone', '$visitor_type', '$flat_number', '$block', '$remark_in')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Visitor added successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

$block_query = "SELECT DISTINCT block FROM Flat_Allotment ORDER BY block";
$block_result = mysqli_query($conn, $block_query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watchman Dashboard</title>
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
            padding: 10px 20px;
        }

        .navbar-brand,
        .navbar-text {
            color: #ffffff !important;
        }

        .navbar-text {
            font-size: 16px;
        }

        .btn-danger {
            font-size: 14px;
            padding: 5px 12px;
        }

        .container-fluid {
            display: flex;
            padding: 0;
        }

        .wrapper {
            display: flex;
            flex-direction: row;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            padding-top: 20px;
            background-color: #2c3e50;
            transition: all 0.3s;
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
            font-size: 16px;
            transition: 0.3s;
        }

        .sidebar ul li a:hover,
        .sidebar ul li a.active {
            background-color: #ff6f61;
        }

        #toggleSidebar {
            display: none;
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

        @media (max-width: 992px) {
            .sidebar {
                width: 200px;
            }
        }

        @media (max-width: 768px) {
            .wrapper {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                display: none;
                position: relative;
            }

            .sidebar.show {
                display: block;
            }

            #toggleSidebar {
                display: inline-block;
            }

            .main-content {
                padding: 20px;
            }
        }
    </style>

    <script>
        function fetchFlats() {
            let selectedBlock = $('#block').val();

            if (selectedBlock !== "") {
                $.ajax({
                    url: "addvisitor_fetch_flats.php",
                    method: "POST",
                    data: {
                        block: selectedBlock
                    },
                    success: function(data) {
                        $('#flat_number').html(data);
                    }
                });
            } else {
                $('#flat_number').html('<option value="">Select Block First</option>');
            }
        }
    </script>

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Smart Society</a>
            <span class="navbar-text ms-auto me-3">Welcome, <?php echo htmlspecialchars($watchman_name); ?></span>
            <a href="watchman_logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </nav>

    <div class="wrapper d-flex">
        <nav class="sidebar " id="sidebar">
            <ul>
                <li><a href="watchman_dashboard.php" class="active">Dashboard</a></li>
                <li><a href="update_visitor_remark.php">Update Visitor Remark</a></li>
                <li><a href="update_maid_remark.php">Update Maid Remark</a></li>
                <li><a href="change_watchman_password.php">Change Password</a></li>
            </ul>
        </nav>

        <div class="main-content flex-grow-1">
            <button class="btn btn-outline-dark d-lg-none mb-3 ms-3" id="toggleSidebar">☰ Menu</button>

            <h2>Add Visitor</h2>
            <div class="form-container">

                <form method="post" action="">
                    <label>Name:</label>
                    <input type="text" name="name" required>

                    <label>Phone:</label>
                    <input type="text" name="phone">

                    <label>Visitor Type:</label>
                    <select name="visitor_type" required>
                        <option value="delivery boy">Delivery Boy</option>
                        <option value="courier">Courier</option>
                        <option value="Guest">Guest</option>
                        <option value="Plumber">Plumber</option>
                    </select>

                    <label>Block:</label>
                    <select name="block" id="block" required onchange="fetchFlats()">
                        <option value="">Select Block</option>
                        <?php while ($row = mysqli_fetch_assoc($block_result)) { ?>
                            <option value="<?php echo htmlspecialchars($row['block']); ?>">
                                <?php echo htmlspecialchars($row['block']); ?>
                            </option>
                        <?php } ?>
                    </select>

                    <label>Flat Number:</label>
                    <select name="flat_number" id="flat_number" required>
                        <option value="">Select Block First</option>
                    </select>

                    <input type="submit" value="Add Visitor">
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("toggleSidebar").addEventListener("click", function() {
            document.getElementById("sidebar").classList.toggle("show");
        });
    </script>

</body>

</html>