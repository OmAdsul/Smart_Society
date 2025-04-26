<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

include_once('../config/db_connection.php');

if (!isset($_GET['id'])) {
    echo "Watchman ID not provided!";
    exit;
}

$watchman_id = $_GET['id'];

$query = "SELECT * FROM Watchmen WHERE watchman_id = '$watchman_id'";
$result = mysqli_query($conn, $query);
$watchman = mysqli_fetch_assoc($result);

if (!$watchman) {
    echo "Watchman not found!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $salary = $_POST['salary'];
    $working_shift = $_POST['working_shift'];

    $update_sql = "UPDATE Watchmen SET name='$name', phone='$phone', salary='$salary', working_shift='$working_shift' WHERE watchman_id='$watchman_id'";

    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Watchman details updated successfully!'); window.location.href='add_watchman.php';</script>";
    } else {
        echo "<script>alert('Error updating watchman: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Update Watchman</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

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
            <a class="navbar-brand" href="add_watchman.php">Back to page</a>
            <a href="admin_logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h2 class="text-center">Update Watchman</h2>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Watchman ID:</label>
                    <input type="text" class="form-control" value="<?php echo $watchman['watchman_id']; ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Name:</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $watchman['name']; ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone:</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo $watchman['phone']; ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Salary:</label>
                    <input type="number" step="0.01" name="salary" class="form-control" value="<?php echo $watchman['salary']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Working Shift:</label>
                    <select name="working_shift" class="form-select" required>
                        <option value="morning" <?php if ($watchman['working_shift'] == 'morning') echo 'selected'; ?>>Morning</option>
                        <option value="evening" <?php if ($watchman['working_shift'] == 'evening') echo 'selected'; ?>>Evening</option>
                        <option value="night" <?php if ($watchman['working_shift'] == 'night') echo 'selected'; ?>>Night</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">Update Watchman</button>
            </form>
        </div>
    </div>

</body>

</html>