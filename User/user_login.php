<?php
session_start();
include_once('../config/db_connection.php');


$registered_flats = [];
if (!empty($_GET['block'])) {
    $block = $_GET['block'];


    $query = "SELECT DISTINCT flat_number FROM Users WHERE block='$block'";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $registered_flats[] = $row['flat_number'];
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $flat_number = mysqli_real_escape_string($conn, $_POST['flat_number']);
    $block = mysqli_real_escape_string($conn, $_POST['block']);
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];


    $sql = "SELECT * FROM Users WHERE flat_number='$flat_number' AND block='$block' AND user_type='$user_type'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {

            $flatQuery = "SELECT * FROM Flat_Allotment WHERE flat_number='$flat_number' AND block='$block'";
            $flatResult = mysqli_query($conn, $flatQuery);
            $flatDetails = mysqli_fetch_assoc($flatResult);


            if ($user_type === 'Owner') {
                if ($flatDetails['name'] !== $user['name']) {
                    echo "<script>alert('Error: Only the registered owner can log in as an Owner.');</script>";
                    exit();
                }
            } elseif ($user_type === 'Renter') {
                if ($flatDetails['ownership_status'] !== 'rented') {
                    echo "<script>alert('Error: This flat is not available for renters.');</script>";
                    exit();
                }
            }


            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['user_type'] = $user_type;
            $_SESSION['flat_number'] = $flat_number;
            $_SESSION['block'] = $block;


            if ($user_type === 'Owner') {
                header('Location: owner_dashboard.php');
            } else {
                header('Location: renter_dashboard.php');
            }
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "Invalid flat number, block, or user type!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }


        .navbar {
            background-color: #2c3e50;
            padding: 15px 0;
        }

        .navbar-brand {
            color: #ffffff !important;
            font-weight: 500;
            font-size: 22px;
        }

        .navbar-nav .nav-link {
            color: #ffffff !important;
            font-weight: 400;
            font-size: 16px;
            margin-right: 15px;
        }

        .navbar-nav .nav-link:hover {
            color: #ff6f61 !important;

        }


        .hero-section {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url('../Images/sample.jpg') no-repeat center center/cover;
            position: relative;
            padding: 20px;
            overflow: hidden;
        }


        .hero-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(28, 28, 28, 0.7);
        }


        .login-container {
            position: relative;
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 8px;
            width: 400px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            margin: 20px;
        }


        .login-container h2 {
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 20px;
        }


        .form-label {
            font-weight: 500;
            color: #2c3e50;
        }

        .form-control {
            border-radius: 4px;
            padding: 10px;
            font-size: 14px;
        }


        .btn-custom {
            background-color: #ff6f61;
            color: #ffffff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            width: 100%;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.3s ease-in-out;
        }

        .btn-custom:hover {
            background-color: #006666;

        }


        .error-message {
            color: red;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 15px;
        }


        @media (max-width: 768px) {
            .login-container {
                width: 90%;
                padding: 30px;
            }

            .navbar-brand {
                font-size: 18px;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#block').on('change', function() {
                var block = $(this).val();
                if (block !== '') {
                    $.ajax({
                        url: 'loginfetch_floor.php',
                        type: 'POST',
                        data: {
                            block: block
                        },
                        success: function(response) {
                            $('#floor').html(response);
                            $('#flat_number').html('<option value="">Select Flat</option>');
                        }
                    });
                } else {
                    $('#floor').html('<option value="">Select Floor</option>');
                    $('#flat_number').html('<option value="">Select Flat</option>');
                }
            });

            $('#floor').on('change', function() {
                var block = $('#block').val();
                var floor = $(this).val();
                if (block !== '' && floor !== '') {
                    $.ajax({
                        url: 'loginfetch_flats.php',
                        type: 'POST',
                        data: {
                            block: block,
                            floor: floor
                        },
                        success: function(response) {
                            $('#flat_number').html(response);
                        }
                    });
                } else {
                    $('#flat_number').html('<option value="">Select Flat</option>');
                }
            });
        });
    </script>

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Smart Society</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="hero-section">
        <div class="login-container">
            <h2>User Login</h2>

            <?php if (isset($error)) : ?>
                <p class="error-message"><?php echo $error; ?></p>
            <?php endif; ?>

            <form method="post" action="">
                <div class="mb-3">
                    <label for="block" class="form-label">Block:</label>
                    <select name="block" id="block" class="form-control" required>
                        <option value="">Select Block</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="floor" class="form-label">Floor:</label>
                    <select name="floor" id="floor" class="form-control" required>
                        <option value="">Select Floor</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="flat_number" class="form-label">Flat Number:</label>
                    <select name="flat_number" id="flat_number" class="form-control" required>
                        <option value="">Select Flat</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="user_type" class="form-label">User Type:</label>
                    <select name="user_type" class="form-control" required>
                        <option value="Owner">Owner</option>
                        <option value="Renter">Renter</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-custom">Login</button>


                <div class="mt-3 d-flex justify-content-between">
                    <a href="forgot_password.php" class="text-decoration-none text-primary">Forgot Password?</a>
                    <a href="user_registration.php" class="text-decoration-none text-primary">Create a New Account</a>
                </div>

            </form>
        </div>
    </div>
</body>

</html>