<?php
include_once('../config/db_connection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
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
            min-height: 100vh;
            background: url('../Images/sample.jpg') no-repeat center center/cover;
            position: relative;
            padding: 20px;
            overflow: hidden;
        }

        .registration-container {
            position: relative;
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 8px;
            width: 700px;
            max-width: 90vw;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
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


        .registration-container h2 {
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
            background-color: #e05a47;
        }

        @media (max-width: 768px) {
            .registration-container {
                width: 90%;
                padding: 30px;
            }

            .navbar-brand {
                font-size: 18px;
            }
        }
    </style>
    <script>
        function fetchFlats() {
            var block = document.getElementById("block").value;
            var floor = document.getElementById("floor").value;

            if (block && floor) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "register_fetch_flats.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        document.getElementById("flat_number").innerHTML = xhr.responseText;
                    }
                };

                xhr.send("block=" + block + "&floor=" + floor);
            } else {
                document.getElementById("flat_number").innerHTML = "<option value=''>Select Flat</option>";
            }
        }
    </script>
</head>

<body>
    <!-- Navbar -->
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
        <div class="registration-container">
            <h2>User Registration</h2>
            <form method="post" action="register_user.php">
                <div class="mb-3">
                    <label class="form-label">Name:</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone:</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Block:</label>
                    <select name="block" id="block" class="form-control" required onchange="fetchFlats()">
                        <option value="">Select Block</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Floor:</label>
                    <select name="floor" id="floor" class="form-control" required onchange="fetchFlats()">
                        <option value="">Select Floor</option>
                        <?php for ($i = 1; $i <= 10; $i++) { ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Flat Number:</label>
                    <select name="flat_number" id="flat_number" class="form-control" required>
                        <option value="">Select Flat</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">User Type:</label>
                    <select name="user_type" class="form-control" required>
                        <option value="Owner">Owner</option>
                        <option value="Renter">Renter</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-custom">Register</button>
            </form>
        </div>
    </div>
</body>

</html>