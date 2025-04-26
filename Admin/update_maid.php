<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

include_once('../config/db_connection.php');
$admin_username = $_SESSION['admin_username'];

if (!isset($_GET['id'])) {
    echo "Maid Number not provided!";
    exit;
}

$maid_number = $_GET['id'];

$block_query = "SELECT DISTINCT block FROM Flat_Allotment";
$block_result = mysqli_query($conn, $block_query);

$query = "SELECT * FROM Maids WHERE maid_number = '$maid_number'";
$result = mysqli_query($conn, $query);
$maid = mysqli_fetch_assoc($result);

if (!$maid) {
    echo "Maid not found!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $contact_number = $_POST['contact_number'];
    $block = $_POST['block'];
    $flat_number = $_POST['flat_number'];

    $update_sql = "UPDATE Maids SET name='$name', contact_number='$contact_number', block='$block', flat_number='$flat_number' WHERE maid_number='$maid_number'";
    mysqli_query($conn, $update_sql);

    echo "<script>alert('Maid details updated successfully!'); window.location.href='add_maid.php';</script>";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Update Maid</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#block").change(function() {
                var block = $(this).val();
                $.ajax({
                    url: "fetch_floors.php",
                    type: "POST",
                    data: {
                        block: block
                    },
                    success: function(data) {
                        $("#floor").html(data);
                        $("#flat_number").html('<option value="">Select Flat</option>');
                    }
                });
            });

            $("#floor").change(function() {
                var block = $("#block").val();
                var floor = $(this).val();
                $.ajax({
                    url: "mfetch_flats.php",
                    type: "POST",
                    data: {
                        block: block,
                        floor: floor
                    },
                    success: function(data) {
                        $("#flat_number").html(data);
                    }
                });
            });
        });
    </script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
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
            padding: 40px;
            max-width: 600px;
            margin: auto;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: white;
            padding: 25px;
        }

        .btn-primary {
            background-color: #ff6f61;
            border: none;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: #e05a47;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Smart Society</a>
            <a class="navbar-brand" href="add_maid.php">Back to page</a>
            <a href="admin_logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h2 class="text-center">Update Maid</h2>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Maid Number:</label>
                    <input type="text" name="maid_number" class="form-control" value="<?php echo $maid['maid_number']; ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Name:</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $maid['name']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contact Number:</label>
                    <input type="text" name="contact_number" class="form-control" value="<?php echo $maid['contact_number']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Block:</label>
                    <select name="block" class="form-select" id="block" required>
                        <option value="">Select Block</option>
                        <?php while ($row = mysqli_fetch_assoc($block_result)) { ?>
                            <option value="<?php echo $row['block']; ?>"><?php echo $row['block']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Floor:</label>
                    <select class="form-select" name="floor" id="floor" required>
                        <option value="">Select Floor</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Flat Number:</label>
                    <select class="form-select" name="flat_number" id="flat_number" required>
                        <option value="">Select Flat</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">Update Maid</button>
            </form>
        </div>
    </div>

</body>

</html>