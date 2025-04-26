<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Residential Society Portal</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('Images/sample.jpg') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }


        .navbar {
            background-color: #2c3e50;
            padding: 15px;
        }

        .navbar-brand {
            font-weight: 500;
            color: white;
        }

        .navbar-nav .nav-link {
            color: white;
        }

        .navbar-nav .nav-link:hover {
            color: #ff6f61;
        }


        .hero-section {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: rgba(28, 28, 28, 0.8);
            padding: 50px 20px;
        }

        .hero-text {
            max-width: 600px;
            color: white;
        }

        .hero-text h1 {
            font-size: 2.5rem;
            font-weight: 500;
            margin-bottom: 15px;
        }

        .hero-text p {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .btn-custom {
            background-color: #ff6f61;
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #e05a47;
        }


        .footer {
            background-color: #2c3e50;
            text-align: center;
            color: white;
            padding: 10px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="">Smart Society</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="admin/admin_login.php">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="watchman/watchman_login.php">Watchman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user/user_login.php">Users</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="hero-section">
        <div class="hero-text">
            <h1>Welcome to Smart Residential Society Portal</h1>
            <p>Manage your society efficiently with ease and security.</p>
            <a href="user_login.php" class="btn btn-custom">Get Started</a>
        </div>
    </div>


    <div class="footer">
        <p>&copy; 2024 Smart Residential Society. All Rights Reserved.</p>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>