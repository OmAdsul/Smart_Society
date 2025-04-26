<?php
include_once('../config/db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $block = mysqli_real_escape_string($conn, $_POST['block']);
    $floor = mysqli_real_escape_string($conn, $_POST['floor']);
    $flat_number = mysqli_real_escape_string($conn, $_POST['flat_number']);
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];


    $query = "SELECT * FROM Flat_Allotment WHERE block='$block' AND floor='$floor' AND flat_number='$flat_number'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $allotment = mysqli_fetch_assoc($result);


        if ($user_type === 'Owner') {
            if ($allotment['name'] !== $name || $allotment['contact_number'] !== $phone) {
                echo "<script>alert('Error: Name and phone number must match the allotment records.'); window.history.back();</script>";
                exit();
            }
            if ($allotment['ownership_status'] !== 'owned') {
                echo "<script>alert('Error: Only owners can register as Owners.'); window.history.back();</script>";
                exit();
            }
        } else if ($user_type === 'Renter') {
            if ($allotment['ownership_status'] !== 'rented') {
                echo "<script>alert('Error: The flat is not available for renters.'); window.history.back();</script>";
                exit();
            }
        }


        $checkUser = "SELECT * FROM Users WHERE block='$block' AND flat_number='$flat_number' AND user_type='$user_type'";
        $userExists = mysqli_query($conn, $checkUser);
        if (mysqli_num_rows($userExists) > 0) {
            echo "<script>alert('Error: User with this flat number and user type is already registered.'); window.history.back();</script>";
            exit();
        }


        $hashed_password = password_hash($password, PASSWORD_BCRYPT);


        $sql = "INSERT INTO Users (name, email, phone, block,  flat_number, password, user_type) 
                VALUES ('$name', '$email', '$phone', '$block',  '$flat_number', '$hashed_password', '$user_type')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Registration successful.'); window.location.href='user_login.php';</script>";
        } else {
            echo "<script>alert('Error: Could not register user.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Error: The selected flat does not match any allotment records.'); window.history.back();</script>";
    }
}
